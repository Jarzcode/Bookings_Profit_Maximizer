<?php

declare(strict_types=1);

namespace SFL\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use SFL\Shared\Application\Query\View;
use SFL\Shared\Domain\Bus\Command\Command;
use SFL\Shared\Domain\Bus\Query\Query;

use function Lambdish\Phunctional\each;

abstract class ApiController
{
    use HandleTrait;

    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly MessageBusInterface $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    ) {
        each(
            fn (int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    abstract protected function exceptions(): array;

    /**
     * @return list<mixed>|View|null
     */
    protected function ask(Query $query): null| array| View
    {
        $this->messageBus = $this->queryBus;
        return $this->handle($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
