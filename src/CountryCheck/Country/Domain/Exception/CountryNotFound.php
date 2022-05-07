<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Exception;

final class CountryNotFound extends \DomainException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('Country not found. Code: %s', $code));
    }
}
