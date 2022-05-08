<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Application\QueryBus;

interface QueryBusResultCache
{
    public function has(Query $query): bool;
    public function get(Query $query): Result;
    public function save(Query $query, Result $result): void;
}
