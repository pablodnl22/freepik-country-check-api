<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Application\CheckCountry;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\JsonSerializableResult;

final class CheckCountryResult extends JsonSerializableResult
{
    public function __construct(
        public readonly bool $result,
        public readonly CountryStatus $criteria,
    ) {
    }

    /**
     * @return array{"result": bool, "criteria": array{"code": bool, "region": bool, "population": bool, "rival": bool}}
     */
    public function jsonSerialize(): array
    {
        return [
            'result' => $this->result,
            'criteria' => [
                'code' => $this->criteria->code,
                'region' => $this->criteria->region,
                'population' => $this->criteria->population,
                'rival' => $this->criteria->rival,
            ]
        ];
    }
}
