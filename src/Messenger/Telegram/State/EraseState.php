<?php

namespace App\Messenger\Telegram\State;

use App\Entity\NotificationSettings;
use App\Entity\TelegramChat;

class EraseState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        $userId = $message['from']['id'];
        $chatId = $message['chat']['id'];
        $settings = $this->entityManager->getRepository(NotificationSettings::class)->findBy([
            'userId' => $userId
        ]);
        $telegramChat = $this->entityManager->getRepository(TelegramChat::class)->findBy([
            'userId' => $userId
        ]);
        foreach ($settings as $setting) {
            $this->entityManager->remove($setting);
        }
        foreach ($telegramChat as $chat) {
            $this->entityManager->remove($chat);
        }
        $this->entityManager->flush();

        return [
            'chat_id' => $chatId,
            'text' => "\xE2\x9D\x8C".'All your data were removed from the bot! Hope you\'ll come back;)'
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new StartState());
    }

}
