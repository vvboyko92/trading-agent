<?php

namespace App\Messenger\Telegram\State;

use App\Messenger\Events\NotifyUserEvent;
use App\Messenger\Telegram\NotificationBuilder\Notification;
use App\Messenger\Telegram\NotificationBuilder\NotificationBuilder;
use App\Messenger\Telegram\SettingsValidator\OrderValidator;
use App\Messenger\Telegram\SettingsValidator\StartValidator;

class SettingsState extends TelegramState
{
    const VALIDATION_MAP = [
        'symbol' => [
            'description' => 'is a currency pair. Case-insensitive.',
            'exampleValue' => 'solusdt',
            'formula' => false
        ],
        'low' => [
            'description' => 'it\'s a price when you will be notified in advance, so notification will be sent at 10+1%.',
            'exampleValue' => '10',
            'formula' => '[value]+([value]*0.01) > [currentPrice]',
        ],
        'tp' => [
            'description' => 'Take profit value. It will notify you when the price will be 20 or higher.',
            'exampleValue' => '20',
            'formula' => '[value] <= [currentPrice]',
        ],
    ];

    public function handleMessage(array $message): array
    {
        $text = $message['text'] ?? $message['message']['text'];
        $chatId = $message['chat']['id'] ?? $message['message']['chat']['id'];
        $notification = $this->resolveMessageCommand($text);
        $notification->chatId = $chatId;
        $notifyUserEvent = new NotifyUserEvent((array)$notification);
        $this->dispatcher->dispatch($notifyUserEvent, NotifyUserEvent::NAME);

        return [
            'chat_id' => $chatId,
            'text' => "\xE2\x9C\x85".'Congratulations! We will notify you, when the price reaches the value you set! Have a good day Sir!)'
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new StartState());
    }

    public function resolveMessageCommand(string $text): Notification
    {
        $rows = explode("\n", $text);
        $notificationBuilder = new NotificationBuilder();
        foreach ($rows as $row) {
            $command = explode(':', $row);
            $commandName = strtolower(trim($command[0]));
            $commandValue = trim($command[1]);
            $commandSettings = static::VALIDATION_MAP[$commandName];
            $notificationBuilder->{'add'.ucfirst($commandName)}([
                'value' => $commandValue,
                'formula' => $commandSettings['formula'],
            ]);
        }

        return $notificationBuilder->getNotification();
    }
}
