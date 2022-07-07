<?php

namespace App\Messenger\Telegram\State;

class ManualState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        $this->context->transitionTo(new GeneralCurrenciesState());

        return $this->context->processMessage($message);
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new GeneralCurrenciesState());
    }
}
