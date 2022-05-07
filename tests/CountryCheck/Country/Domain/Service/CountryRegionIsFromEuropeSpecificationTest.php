<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckingResult;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryRegionIsFromEuropeSpecification;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;
use PHPUnit\Framework\TestCase;

final class CountryRegionIsFromEuropeSpecificationTest extends TestCase
{
    public function testGivenCountryWhenRegionIsNotFromEuropeThenFail(): void
    {
        $sut = new CountryRegionIsFromEuropeSpecification();

        $givenCountry = new Country(
            Code::from('col'),
            Region::from('americas'),
            Population::from(84)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(regionIsEurope: false);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenCountryWhenRegionIsFromEuropeThenSuccess(): void
    {
        $sut = new CountryRegionIsFromEuropeSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('europe'),
            Population::from(84)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(regionIsEurope: true);

        self::assertEquals($expectedResult, $result);
    }
}
