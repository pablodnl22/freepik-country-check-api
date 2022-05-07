<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Exception;

final class NorwayNotFound extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Norway not found');
    }
}
