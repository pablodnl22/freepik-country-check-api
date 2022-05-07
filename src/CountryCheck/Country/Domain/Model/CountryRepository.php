<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Model;

use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;

interface CountryRepository
{
    public function findByCode(Code $code): ?Country;
}
