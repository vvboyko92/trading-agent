<?php

namespace App\Messenger\Telegram\State;

class CancelState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        $this->context->transitionTo(new StartState());
        return $this->handleMessage($message);
    }

    public function resolveNextState(string $command): void
    {
    }
}
