<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Exception\NorwayNotFound;
use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Model\CountryRepository;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;

final class CountryPopulationIsBiggerThanNorwaySpecification implements CountryCheckSpecification
{
    private const NORWAY_CODE = 'NOR';

    public function __construct(private readonly CountryRepository $repository)
    {
    }

    public function valid(Country $country, CountryCheckingResult $checkingResult): CountryCheckingResult
    {
        $norway = $this->repository->findByCode(Code::from(self::NORWAY_CODE));

        if (null === $norway) {
            throw new NorwayNotFound();
        }

        return $checkingResult->withPopulationIsBiggerThanNorway(
            $country->population()->value() > $norway->population()->value()
        );
    }
}
