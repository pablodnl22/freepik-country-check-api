<?php

namespace CountryCheckApi;

use CountryCheckApi\CountryCheck\Shared\Infrastructure\Symfony\QueryLoaderCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new QueryLoaderCompilerPass());
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $customRoutingDir = $this->getProjectDir() . '/src/*';
        $finder = (new Finder())->directories()->depth('== 0')->in($customRoutingDir);

        foreach ($finder as $controller) {
            $path = $controller->getRealPath() . '/Infrastructure/Adapter/RestAPI';
            if (file_exists($path)) {
                $routes->import($path, 'annotation');
            }
        }

        $confDir = $this->getProjectDir() . '/config';
        $routes->import($confDir . '/routes.yaml');
    }
}
