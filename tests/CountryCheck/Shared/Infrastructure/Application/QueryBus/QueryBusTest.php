<?php

declare(strict_types=1);

namespace CountryCheckApi\Tests\CountryCheck\Shared\Infrastructure\Application\QueryBus;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Query;
use CountryCheckApi\CountryCheck\Shared\Infrastructure\Application\QueryBus\QueryBus;
use PHPUnit\Framework\TestCase;

final class QueryBusTest extends TestCase
{
    public function testGivenQueryWhenQueryBusHasNotMiddlewaresThenFail(): void
    {
        $sut = new QueryBus();

        $givenQuery = new DummyQuery();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Middlewares not found to dispatch %s', DummyQuery::class));

        $sut->execute($givenQuery);
    }

    public function testGivenQueryWhenQueryBusHasMiddlewaresThenDispatchQueryInMiddlewares(): void
    {
        $dummyMiddleware = new DummyMiddleware();

        $resultGeneratorMiddleware = new StubMiddlewareForResultGeneration();

        $sut = new QueryBus($dummyMiddleware, $resultGeneratorMiddleware);

        $givenQuery = new DummyQuery();

        $actualResult = $sut->execute($givenQuery);

        $expectedResult = new DummyResult();

        self::assertEquals($expectedResult, $actualResult);
    }
}
