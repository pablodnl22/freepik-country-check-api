<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Application\QueryBus;

final class DeclaredQueryCollection
{
    /**
     * @param array<string, string> $queries
     */
    public function __construct(private array $queries = [])
    {
    }

    public function handlerOf(Query $query): ?string
    {
        return $this->queries[$query::class] ?? null;
    }

    public function declareQuery(string $queryClass, string $handlerClass): self
    {
        $this->queries[$queryClass] = $handlerClass;

        return $this;
    }
}
