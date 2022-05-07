<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;

final class CountryCodeFirstLetterIsVocalSpecification implements CountryCheckSpecification
{
    public function valid(Country $country, CountryCheckingResult $checkingResult): CountryCheckingResult
    {
        return $checkingResult->withCodeFirstLetterIsVocal(
            (bool)preg_match('/^[AEIOU]/', $country->code()->value())
        );
    }
}
