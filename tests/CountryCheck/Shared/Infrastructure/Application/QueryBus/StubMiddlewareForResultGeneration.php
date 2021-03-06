<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Shared\Infrastructure\Application\QueryBus;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Middleware;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;

final class StubMiddlewareForResultGeneration implements Middleware
{
    public function __invoke(Query $query, callable $next): Result
    {
        return new DummyResult();
    }
}
