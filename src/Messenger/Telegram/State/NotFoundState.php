<?php

namespace App\Messenger\Telegram\State;

class NotFoundState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        $text = 'Command not found or not implemented yet. Message me to v.v.boyko92@gmail.com or https://t.me/Retvall to implement new features!';
        return [
            'chat_id' => $message['chat']['id'] ?? $message['message']['chat']['id'],
            'text' => $text
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new StartState());
    }

}
