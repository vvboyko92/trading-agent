<?php

namespace App\Messenger\Telegram\State;

class InitialState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        return [
            'chat_id' => $message['chat']['id'] ?? $message['message']['chat']['id'],
            'text' => 'Welcome back!) type /start to start from the beginning)'
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new StartState());
    }

}
