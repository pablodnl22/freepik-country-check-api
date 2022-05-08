<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Infrastructure\Symfony;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\DeclaredQueryCollection;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class QueryLoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->has(DeclaredQueryCollection::class)) {
            return;
        }

        $queries = array_filter(
            get_declared_classes(),
            static fn (string $class) => is_subclass_of($class, Query::class)
        );

        foreach ($queries as $query) {
            $conventionHandler = $query . 'Handler';

            if (false === $container->has($conventionHandler)) {
                continue;
            }

            $container->getDefinition($conventionHandler)->setPublic(true);
            $container->getDefinition(DeclaredQueryCollection::class)->addMethodCall(
                'declareQuery',
                [$query, $conventionHandler]
            );
        }
    }
}
