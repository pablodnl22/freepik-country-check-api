<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Infrastructure\Application\QueryBus;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Middleware;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;
use function CountryCheckApi\CountryCheck\Shared\Domain\Util\Function\chain;

final class QueryBus implements \CountryCheckApi\CountryCheck\Shared\Application\QueryBus\QueryBus
{
    /** @var Middleware[] */
    private array $middlewares;

    public function __construct(Middleware ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function execute(Query $query): Result
    {
        if (empty($this->middlewares)) {
            throw new \RuntimeException(sprintf('Middlewares not found to dispatch %s', $query::class));
        }

        return chain(...$this->middlewares)($query);
    }
}
