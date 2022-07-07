<?php

namespace App\Messenger\Telegram\State;

use App\Entity\BinanceApiKeys;
use App\Repository\BinanceApiKeysRepository;

class BinanceSecretState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        /** @var BinanceApiKeysRepository $repository */
        $repository = $this->entityManager->getRepository(BinanceApiKeys::class);
        $userId = $message['from']['id'];
        $apiKeys = $repository->getApiKeys($userId);
        if (!$apiKeys) {
            $apiKeys = new BinanceApiKeys();
            $apiKeys->setUserId($userId);
            $apiKeys->setApiKey($message['message']['text'] ?? $message['text']);
            $this->entityManager->persist($apiKeys);
            $this->entityManager->flush();
        }

        return [
            'chat_id' => $message['chat']['id'] ?? $message['message']['chat']['id'],
            'text' => 'Please enter SECRET KEY!'
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new SavedApiKeys());
    }

}
