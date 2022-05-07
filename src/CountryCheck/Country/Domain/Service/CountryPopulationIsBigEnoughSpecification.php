<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;

final class CountryPopulationIsBigEnoughSpecification implements CountryCheckSpecification
{
    private const LIMIT_TO_CONSIDER_BIG_COUNTRY = 50000000;
    private const LIMIT_TO_CONSIDER_BIG_COUNTRY_IN_ASIA = 80000000;

    public function valid(Country $country, CountryCheckingResult $checkingResult): CountryCheckingResult
    {
        $populationChecker = match (true) {
            $country->region()->isAsia() => $this->checkIfAsianCountryIsBigEnough(...),
            default => $this->checkIfCountryIsBigEnough(...)
        };

        return $checkingResult->withPopulationIsBigEnough(
            $populationChecker($country->population())
        );
    }

    private function checkIfAsianCountryIsBigEnough(Population $population): bool
    {
        return $population->value() >= self::LIMIT_TO_CONSIDER_BIG_COUNTRY_IN_ASIA;
    }

    private function checkIfCountryIsBigEnough(Population $population): bool
    {
        return $population->value() >= self::LIMIT_TO_CONSIDER_BIG_COUNTRY;
    }
}
