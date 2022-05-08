<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Infrastructure\Application\QueryBus;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\QueryBusResultCache;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;

final class InMemoryQueryBusResultCache implements QueryBusResultCache
{
    /** @var array<string, mixed> */
    private array $cache = [];

    public function has(Query $query): bool
    {
        return array_key_exists($this->generateKeyFrom($query), $this->cache);
    }

    public function get(Query $query): Result
    {
        return $this->cache[$this->generateKeyFrom($query)];
    }

    public function save(Query $query, Result $result): void
    {
        $this->cache[$this->generateKeyFrom($query)] = $result;
    }

    private function generateKeyFrom(Query $query): string
    {
        return hash('md5', (string)json_encode($query));
    }
}
