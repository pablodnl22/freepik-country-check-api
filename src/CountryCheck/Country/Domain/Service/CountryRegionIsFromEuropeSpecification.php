<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;

final class CountryRegionIsFromEuropeSpecification implements CountryCheckSpecification
{
    public function valid(Country $country, CountryCheckingResult $checkingResult): CountryCheckingResult
    {
        return $checkingResult->withRegionIsEurope($country->region()->isEurope());
    }
}
