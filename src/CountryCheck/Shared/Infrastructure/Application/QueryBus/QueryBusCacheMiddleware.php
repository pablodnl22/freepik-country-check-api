<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Infrastructure\Application\QueryBus;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Middleware;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\QueryBusResultCache;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;

final class QueryBusCacheMiddleware implements Middleware
{
    public function __construct(private readonly QueryBusResultCache $queryBusResultCache)
    {
    }

    public function __invoke(Query $query, callable $next): Result
    {
        return $this->queryBusResultCache->has($query)
            ? $this->queryBusResultCache->get($query)
            : $this->callNextAndCacheResult($query, $next);
    }

    private function callNextAndCacheResult(Query $query, callable $next): Result
    {
        $result = $next($query);

        $this->queryBusResultCache->save($query, $result);

        return $result;
    }
}
