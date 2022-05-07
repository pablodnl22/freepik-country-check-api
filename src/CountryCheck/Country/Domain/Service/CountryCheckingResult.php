<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Service;

final class CountryCheckingResult
{
    public function __construct(
        private bool $codeFirstLetterIsVocal = false,
        private bool $regionIsEurope = false,
        private bool $populationIsBigEnough = false,
        private bool $populationIsBiggerThanNorway = false
    ) {
    }

    public function codeFirstLetterIsVocal(): bool
    {
        return $this->codeFirstLetterIsVocal;
    }

    public function withCodeFirstLetterIsVocal(bool $codeFirstLetterIsVocal): self
    {
        $clone = clone $this;
        $clone->codeFirstLetterIsVocal = $codeFirstLetterIsVocal;
        return $clone;
    }

    public function regionIsEurope(): bool
    {
        return $this->regionIsEurope;
    }

    public function withRegionIsEurope(bool $regionIsEurope): self
    {
        $clone = clone $this;
        $clone->regionIsEurope = $regionIsEurope;
        return $clone;
    }

    public function populationIsBigEnough(): bool
    {
        return $this->populationIsBigEnough;
    }

    public function withPopulationIsBigEnough(bool $populationIsBigEnough): self
    {
        $clone = clone $this;
        $clone->populationIsBigEnough = $populationIsBigEnough;
        return $clone;
    }

    public function populationIsBiggerThanNorway(): bool
    {
        return $this->populationIsBiggerThanNorway;
    }

    public function withPopulationIsBiggerThanNorway(bool $populationIsBiggerThanNorway): self
    {
        $clone = clone $this;
        $clone->populationIsBiggerThanNorway = $populationIsBiggerThanNorway;
        return $clone;
    }
}
