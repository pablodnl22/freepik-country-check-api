<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckingResult;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckSpecification;

final class StubSpecificationToApproveAll implements CountryCheckSpecification
{
    public function valid(Country $country, CountryCheckingResult $checkingResult): CountryCheckingResult
    {
        return $checkingResult
            ->withRegionIsEurope(true)
            ->withCodeFirstLetterIsVocal(true)
            ->withPopulationIsBigEnough(true)
            ->withPopulationIsBiggerThanNorway(true);       
    }
}
