<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Application\QueryBus;

abstract class JsonSerializableResult implements Result, \JsonSerializable
{
    abstract public function jsonSerialize(): array;
}
