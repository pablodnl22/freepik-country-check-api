<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Infrastructure\Adapter\RestAPI;

use CountryCheckApi\CountryCheck\Country\Application\CheckCountry\CheckCountryQuery;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\JsonSerializableResult;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/country-check/{countryCode}')]
final class CountryCheckController
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new CheckCountryQuery($request->attributes->getAlpha('countryCode'));

        $response = $this->queryBus->execute($query);

        return new JsonResponse($response);
    }
}
