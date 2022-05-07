<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Country\Application\CheckCountry;

use CountryCheckApi\CountryCheck\Country\Application\CheckCountry\CheckCountryQuery;
use CountryCheckApi\CountryCheck\Country\Application\CheckCountry\CheckCountryQueryHandler;
use CountryCheckApi\CountryCheck\Country\Application\CheckCountry\CheckCountryResult;
use CountryCheckApi\CountryCheck\Country\Application\CheckCountry\CountryStatus;
use CountryCheckApi\CountryCheck\Country\Domain\Exception\CountryNotFound;
use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Model\CountryRepository;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;
use CountryCheckApi\Tests\CountryCheck\Country\Domain\Service\StubSpecificationToApproveAll;
use PHPUnit\Framework\TestCase;

final class CheckCountryQueryHandlerTest extends TestCase
{
    public function testGivenQueryWhenCountryNotFoundThenFail(): void
    {
        $stubForNullCountry = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubForNullCountry->expects($this->once())->method('findByCode')->willReturn(null);

        $sut = new CheckCountryQueryHandler($stubForNullCountry);

        $givenQuery = new CheckCountryQuery('ESP');

        $this->expectException(CountryNotFound::class);

        $sut($givenQuery);
    }

    public function testGivenQueryWhenHandlerHasNotSpecificationsThenAllCriteriaShouldBeFalse(): void
    {
        $stubRepository = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubRepository->expects($this->once())->method('findByCode')->willReturn($this->getCountry());

        $sut = new CheckCountryQueryHandler($stubRepository);

        $givenQuery = new CheckCountryQuery('ESP');

        $result = $sut($givenQuery);

        $expectedResult = new CheckCountryResult(
            false,
            new CountryStatus(
                false,
                false,
                false,
                false
            )
        );

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenQueryWhenHandlerAllSpecificationsAreValidThenAllCriteriaShouldBeTrue(): void
    {
        $stubRepository = $this->getMockBuilder(CountryRepository::class)->getMock();
        $stubRepository->expects($this->once())->method('findByCode')->willReturn($this->getCountry());

        $sut = new CheckCountryQueryHandler($stubRepository, new StubSpecificationToApproveAll());

        $givenQuery = new CheckCountryQuery('ESP');

        $result = $sut($givenQuery);

        $expectedResult = new CheckCountryResult(
            true,
            new CountryStatus(
                true,
                true,
                true,
                true
            )
        );

        self::assertEquals($expectedResult, $result);
    }

    private function getCountry(): Country
    {
        return new Country(Code::from('ESP'), Region::from('Europe'), Population::from(2));
    }
}
