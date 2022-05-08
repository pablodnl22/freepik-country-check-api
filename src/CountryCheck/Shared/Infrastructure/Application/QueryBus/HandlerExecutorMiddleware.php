<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Infrastructure\Application\QueryBus;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\DeclaredQueryCollection;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Middleware;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;
use Psr\Container\ContainerInterface;

final class HandlerExecutorMiddleware implements Middleware
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly DeclaredQueryCollection $declaredQueryCollection
    ) {
    }

    public function __invoke(Query $query, callable $next): Result
    {
        $handler = $this->declaredQueryCollection->handlerOf($query);

        if (null === $handler || false === $this->container->has($handler)) {
            throw new \RuntimeException(sprintf('Missing handler for: %s', $query::class));
        }

        return $this->container->get($handler)($query);
    }
}
