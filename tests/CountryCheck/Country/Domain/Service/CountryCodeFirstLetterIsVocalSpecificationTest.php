<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckingResult;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCodeFirstLetterIsVocalSpecification;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;
use PHPUnit\Framework\TestCase;

final class CountryCodeFirstLetterIsVocalSpecificationTest extends TestCase
{
    public function testGivenCountryWhenCodeFirstLetterIsConsonantThenFail(): void
    {
        $sut = new CountryCodeFirstLetterIsVocalSpecification();

        $givenCountry = new Country(
            Code::from('COL'),
            Region::from('Americas'),
            Population::from(34)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(codeFirstLetterIsVocal: false);

        self::assertEquals($expectedResult, $result);
    }

    public function testGivenCountryWhenCodeFirstLetterIsVocalThenSuccess(): void
    {
        $sut = new CountryCodeFirstLetterIsVocalSpecification();

        $givenCountry = new Country(
            Code::from('ALB'),
            Region::from('Europe'),
            Population::from(34)
        );

        $result = $sut->valid($givenCountry, new CountryCheckingResult());

        $expectedResult = new CountryCheckingResult(codeFirstLetterIsVocal: true);

        self::assertEquals($expectedResult, $result);
    }
}
