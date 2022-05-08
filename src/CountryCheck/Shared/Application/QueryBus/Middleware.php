<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Application\QueryBus;

interface Middleware
{
    public function __invoke(Query $query, callable $next): Result;
}
