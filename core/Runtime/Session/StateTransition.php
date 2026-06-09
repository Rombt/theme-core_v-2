<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use InvalidArgumentException;
use Rombt\ThemeCore\Runtime\Contracts\StateTransitionInterface;

final class StateTransition implements StateTransitionInterface
{
    /**
     * @var array<string, array<string>>
     */
    private array $allowed = [
        RuntimeState::CREATED => [
            RuntimeState::RUNNING,
            RuntimeState::CANCELLED,
        ],
        RuntimeState::RUNNING => [
            RuntimeState::COMPLETED,
            RuntimeState::FAILED,
            RuntimeState::CANCELLED,
        ],
        RuntimeState::FAILED => [],
        RuntimeState::COMPLETED => [],
        RuntimeState::CANCELLED => [],
    ];

    public function transition(
        BuildSession $session,
        string $toState
    ): void {
        $from = $session->getState();

        if (!RuntimeState::isValid($toState)) {
            throw new InvalidArgumentException("Invalid state: {$toState}");
        }

        if (!in_array($toState, $this->allowed[$from] ?? [], true)) {
            throw new InvalidArgumentException(
                "Invalid transition: {$from} → {$toState}"
            );
        }

        $session->setState($toState);
    }
}
