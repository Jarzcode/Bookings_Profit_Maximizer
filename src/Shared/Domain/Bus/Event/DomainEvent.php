<?php

declare(strict_types=1);

namespace SFL\Shared\Domain\Bus\Event;

use SFL\Shared\Domain\Utils;
use SFL\Shared\Domain\ValueObject\SimpleUuid;
use DateTimeImmutable;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(private readonly string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId = $eventId ?: SimpleUuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
