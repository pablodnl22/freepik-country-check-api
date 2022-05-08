<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Infrastructure\Domain\Model\RestCountriesApi;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Model\CountryRepository;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;

final class RestCountriesApiCountryRepository implements CountryRepository
{
    private const REST_COUNTRIES_BASE_URL = 'https://restcountries.com/v3.1/alpha';

    public function findByCode(Code $code): ?Country
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::REST_COUNTRIES_BASE_URL . '?codes=' . $code->value());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        $primitiveCountry = !curl_errno($ch) && $this->successfullyRequest($info['http_code'])
            ? json_decode((string)$result, true, 512, JSON_THROW_ON_ERROR)
            : [];

        if (false === empty($primitiveCountry) && array_is_list($primitiveCountry)) {
            $primitiveCountry = $primitiveCountry[array_key_first($primitiveCountry)];
        }

        return false === empty($primitiveCountry)
            ?  $this->instanceCountryFromArray($primitiveCountry)
            : null;
    }

    /**
     * @param array{'cca2': string, "region": string, "population": int} $decode
     * @return Country
     */
    private function instanceCountryFromArray(array $decode): Country
    {
        return new Country(
            Code::from($decode['cca2']),
            Region::from($decode['region']),
            Population::from($decode['population'])
        );
    }

    public function successfullyRequest(int $statusCode): bool
    {
        return $statusCode >= 200 && $statusCode < 300;
    }
}
