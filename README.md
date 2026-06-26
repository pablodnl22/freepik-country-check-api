# Country Checker API

A small REST API that, given a country code, evaluates a set of criteria and
returns whether **all** of them hold. Built as a backend coding exercise for
Freepik — deliberately engineered like a larger project (hexagonal architecture,
DDD, a CQRS-style query bus and dependency injection) rather than as a one-file
script, so that criteria are easy to add or change.

## The task

`GET /country-check/{countryCode}` evaluates four criteria and returns each one
plus the overall result:

| Criterion | `true` when… |
|-----------|--------------|
| `code` | the country code starts with a **vowel** |
| `region` | the country's region is **Europe** |
| `population` | population ≥ **80M** for Asian countries, or ≥ **50M** for any other region |
| `rival` | the country's population is **greater than Norway's** |

```jsonc
// GET /country-check/es  (Spain: code starts with "E", in Europe,
//                         ~47M population, larger than Norway)
{
  "result": false,
  "criteria": {
    "code": true,
    "region": true,
    "population": false,
    "rival": true
  }
}
```

Errors return a JSON body with an appropriate HTTP status (e.g. an unknown code
yields a `CountryNotFound` mapped to a 4xx response); unexpected failures fall
back to a generic `500`. Country data comes from
[restcountries.com](https://restcountries.com/v3.1/alpha).

## Architecture

The code follows **Hexagonal (Ports & Adapters) + DDD**, with the domain free of
framework dependencies and Symfony kept at the edges:

```
src/CountryCheck/
├── Country/
│   ├── Domain/              # framework-agnostic core
│   │   ├── Model/           # Country, CountryRepository (port)
│   │   ├── ValueObject/     # Code, Region, Population
│   │   ├── Service/         # CountryCheckSpecification + 4 implementations
│   │   └── Exception/       # CountryNotFound, NorwayNotFound
│   ├── Application/
│   │   └── CheckCountry/    # Query, Handler, Result, CountryStatus
│   └── Infrastructure/
│       ├── Adapter/RestAPI/ # CountryCheckController (HTTP)
│       └── Domain/Model/    # RestCountriesApiCountryRepository (adapter)
└── Shared/                  # custom QueryBus + middleware, exceptions, VO base
```

Key design choices:

- **Specification pattern for the criteria.** Each criterion is an isolated
  `CountryCheckSpecification`. The handler is injected with the full set
  (variadic constructor) and folds them over the country with `array_reduce`, so
  a criterion lives entirely in its own class and is wired in one place
  (`config/services.yaml`).
- **CQRS-style query bus.** Requests flow through a small `QueryBus` with a
  middleware pipeline (result cache → handler executor), decoupling the
  controller from the handler.
- **Ports & adapters.** The domain depends on a `CountryRepository` interface;
  the `restcountries.com` HTTP call is an infrastructure adapter that can be
  swapped or stubbed without touching the domain.
- **Value objects** (`Code`, `Region`, `Population`) keep primitives and
  validation out of the domain logic.
- **Centralised error handling** via a Symfony `ExceptionListener` that maps
  domain exceptions to HTTP responses.

## Running it

Requires Docker. The stack is Nginx + PHP-FPM (PHP 8.1):

```bash
docker-compose up -d --build
docker exec -it fpm_country_check bin/composer.phar install
```

The API is then available at:

```bash
curl http://localhost:8023/country-check/es
```

## Testing

Unit tests cover each specification in isolation and the query handler;
functional tests cover the query bus and its middleware (using hand-written
stubs/dummies as test doubles).

```bash
docker exec -it fpm_country_check bin/composer.phar tests   # phpunit
```

## Code quality

- **PHPUnit** — unit + functional tests
- **PHP_CodeSniffer** — `PSR12` ruleset (`phpcs.xml.dist`)
- **PHPStan** — static analysis
- **roave/security-advisories** — blocks dependencies with known vulnerabilities

## Stack & notes

PHP 8.1 · Symfony 6.0 · Nginx + PHP-FPM · PHPUnit 9.5 · PHPStan · PHP_CodeSniffer.

> The brief left the architecture open (and suggested Slim 3+). I chose Symfony 6
> to lean on its DI container and Flex tooling while keeping the framework at the
> edges — the domain and application layers have no Symfony dependencies, so the
> core would survive a framework swap.
