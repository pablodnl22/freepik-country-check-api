<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Domain\Util\Function;

function chain(callable ...$handlers): callable
{
    $carry = static function () {
    };

    while ($handler = array_pop($handlers)) {
        $carry = static fn ($value) => $handler($value, $carry);
    }

    return $carry;
}

const chain = 'CountryCheckApi\CountryCheck\Shared\Domain\Util\Function';
