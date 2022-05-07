<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Exception\NorwayNotFound;
use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Model\CountryRepository;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckingResult;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryPopulationIsBiggerThanNorwaySpecification;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;
use PHPUnit\Framework\TestCase;

final class CountryPopulationIsBiggerThanNorwaySpecificationTest extends TestCase
{
    private const NORWAY_POPULATION = 40000;

    public function testGivenCountryWhenNorwayNotFoundThenFail(): void
    {
        $stubForNullCountry = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubForNullCountry->expects($this->once())->method('findByCode')->willReturn(null);

        $sut = new CountryPopulationIsBiggerThanNorwaySpecification($stubForNullCountry);

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(32)
        );

        $this->expectException(NorwayNotFound::class);

        $sut->valid($givenCountry, new CountryCheckingResult());
    }

    public function testGivenCountryWhenPopulationIsLowerThanNorwayThenFail(): void
    {
        $stubRepository = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubRepository->expects($this->once())->method('findByCode')->willReturn(
            $this->getNorway()
        );

        $sut = new CountryPopulationIsBiggerThanNorwaySpecification($stubRepository);

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(32)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBiggerThanNorway: false);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenCountryWhenPopulationIsTheSameAsNorwayThenFail(): void
    {
        $stubRepository = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubRepository->expects($this->once())->method('findByCode')->willReturn(
            $this->getNorway()
        );

        $sut = new CountryPopulationIsBiggerThanNorwaySpecification($stubRepository);

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(self::NORWAY_POPULATION)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBiggerThanNorway: false);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenCountryWhenPopulationIsBiggerThanNorwayThenSuccess(): void
    {
        $stubRepository = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubRepository->expects($this->once())->method('findByCode')->willReturn(
            $this->getNorway()
        );

        $sut = new CountryPopulationIsBiggerThanNorwaySpecification($stubRepository);

        $givenCountry = new Country(
            Code::from('alb'),
            Region::from('Europe'),
            Population::from(40001)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(populationIsBiggerThanNorway: true);

        self::assertEquals($expectedResult, $result);
    }

    private function getNorway(): Country
    {
        return new Country(Code::from('NOR'), Region::from('Europe'), Population::from(self::NORWAY_POPULATION));
    }
}
