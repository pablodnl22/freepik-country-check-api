<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Application\CheckCountry;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;

final class CheckCountryQuery implements Query
{
    public function __construct(public readonly string $code)
    {
    }
}
