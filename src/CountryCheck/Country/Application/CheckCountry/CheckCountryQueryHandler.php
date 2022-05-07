<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Application\CheckCountry;

use CountryCheckApi\CountryCheck\Country\Domain\Exception\CountryNotFound;
use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;
use CountryCheckApi\CountryCheck\Country\Domain\Model\CountryRepository;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckingResult;
use CountryCheckApi\CountryCheck\Country\Domain\Service\CountryCheckSpecification;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;

final class CheckCountryQueryHandler
{
    /** @var CountryCheckSpecification[] */
    private readonly array $countryCheckSpecifications;

    public function __construct(
        private readonly CountryRepository $repository,
        CountryCheckSpecification ...$countryCheckSpecifications
    ) {
        $this->countryCheckSpecifications = $countryCheckSpecifications;
    }

    public function __invoke(CheckCountryQuery $query): Result
    {
        $country = $this->repository->findByCode(Code::from($query->code));

        if (null === $country) {
            throw new CountryNotFound($query->code);
        }

        $checkingResult = $this->applyAllSpecificationsOverThisCountry($country);

        return new CheckCountryResult(
            $this->allSpecificationsAreValid($checkingResult),
            new CountryStatus(
                $checkingResult->codeFirstLetterIsVocal(),
                $checkingResult->regionIsEurope(),
                $checkingResult->populationIsBigEnough(),
                $checkingResult->populationIsBiggerThanNorway()
            )
        );
    }

    private function applyAllSpecificationsOverThisCountry(Country $country): CountryCheckingResult
    {
        $apply = static fn(
            CountryCheckingResult $result,
            CountryCheckSpecification $specification
        ) => $specification->valid($country, $result);

        return array_reduce(
            $this->countryCheckSpecifications,
            $apply,
            new CountryCheckingResult()
        );
    }

    private function allSpecificationsAreValid(CountryCheckingResult $checkingResult): bool
    {
        return $checkingResult->codeFirstLetterIsVocal()
            && $checkingResult->regionIsEurope()
            && $checkingResult->populationIsBigEnough()
            && $checkingResult->populationIsBiggerThanNorway();
    }
}
