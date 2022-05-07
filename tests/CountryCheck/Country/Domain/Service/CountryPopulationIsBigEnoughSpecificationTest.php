<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckingResult;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryPopulationIsBigEnoughSpecification;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;
use PHPUnit\Framework\TestCase;

final class CountryPopulationIsBigEnoughSpecificationTest extends TestCase
{
    public function testGivenCountryWhenPopulationIsLowThenFail(): void
    {
        $sut = new CountryPopulationIsBigEnoughSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(4)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBigEnough: false);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenEuropeanCountryWhenPopulationIsInTheLimitThenSuccess(): void
    {
        $sut = new CountryPopulationIsBigEnoughSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(50000000)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBigEnough: true);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenEuropeanCountryWhenPopulationOverTheLimitThenSuccess(): void
    {
        $sut = new CountryPopulationIsBigEnoughSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(50000001)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBigEnough: true);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenAsianCountryWhenPopulationIsLowThenFail(): void
    {
        $sut = new CountryPopulationIsBigEnoughSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Asia'),
            Population::from(50000001)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBigEnough: false);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenAsianCountryWhenPopulationIsInTheLimitThenSuccess(): void
    {
        $sut = new CountryPopulationIsBigEnoughSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Asia'),
            Population::from(80000000)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBigEnough: true);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenAsianCountryWhenPopulationIsOverTheLimitThenSuccess(): void
    {
        $sut = new CountryPopulationIsBigEnoughSpecification();

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Asia'),
            Population::from(80000001)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBigEnough: true);

        self::assertEquals($expectedResult, $result);
    }
}
