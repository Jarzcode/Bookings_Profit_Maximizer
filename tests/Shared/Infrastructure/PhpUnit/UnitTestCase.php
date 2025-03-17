<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit;

use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Tests\Shared\Domain\TestUtils;
use Tests\Shared\Infrastructure\Mockery\MyCompanyMatcherIsSimilar;
use SFL\Shared\Domain\Bus\Command\Command;
use SFL\Shared\Domain\Bus\Event\DomainEvent;
use SFL\Shared\Domain\Bus\Event\EventBus;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

abstract class UnitTestCase extends MockeryTestCase
{
	private EventBus | MockInterface | null $eventBus = null;
	private MockInterface | UuidGenerator | null $uuidGenerator = null;

	protected function mock(string $className): MockInterface
	{
		return Mockery::mock($className);
	}

	protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
	{
		$this->eventBus()
			->shouldReceive('publish')
			->with($this->similarTo($domainEvent))
			->andReturnNull();
	}

	protected function shouldNotPublishDomainEvent(): void
	{
		$this->eventBus()
			->shouldReceive('publish')
			->withNoArgs()
			->andReturnNull();
	}

	protected function eventBus(): EventBus | MockInterface
	{
		return $this->eventBus ??= $this->mock(EventBus::class);
	}

	protected function uuidGenerator(): MockInterface | UuidGenerator
	{
		return $this->uuidGenerator ??= $this->mock(UuidGenerator::class);
	}

    protected function dispatch(Command $command, callable $commandHandler): void
    {
        $commandHandler($command);
    }

	protected function isSimilar(mixed $expected, mixed $actual): bool
	{
		return TestUtils::isSimilar($expected, $actual);
	}

	protected function assertSimilar(mixed $expected, mixed $actual): void
	{
		TestUtils::assertSimilar($expected, $actual);
	}

	protected function similarTo(mixed $value, float $delta = 0.0): MyCompanyMatcherIsSimilar
	{
		return TestUtils::similarTo($value, $delta);
	}
}
