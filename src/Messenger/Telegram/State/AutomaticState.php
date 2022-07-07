<?php

namespace App\Messenger\Telegram\State;

class AutomaticState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        return [
            'chat_id' => $message['chat']['id'] ?? $message['message']['chat']['id'],
            'text' => 'Please enter API KEY!'
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new BinanceApiKeyState());
    }
}
