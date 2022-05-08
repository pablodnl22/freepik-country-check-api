<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Domain\Exception;

enum ExceptionCode
{
    case NotFound;
    case BadBusinessLogic;

    public function toHttpCode(): int
    {
        return match ($this) {
            self::NotFound => 404,
            self::BadBusinessLogic => 400
        };
    }
}
