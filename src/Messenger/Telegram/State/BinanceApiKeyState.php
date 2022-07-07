<?php

namespace App\Messenger\Telegram\State;

use App\Entity\BinanceApiKeys;
use App\Repository\BinanceApiKeysRepository;

class BinanceApiKeyState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        /** @var BinanceApiKeysRepository $repository */
        $repository = $this->entityManager->getRepository(BinanceApiKeys::class);
        $userId = $message['from']['id'];
        /** @var BinanceApiKeys $apiKeys */
        $apiKeys = $repository->getApiKeys($userId);
        if ($apiKeys && $apiKeys->getApiKey() && $apiKeys->getApiSecret()) {
            $this->context->transitionTo(new SavedApiKeys());
            return $this->context->processMessage($message);
        }

        $this->context->transitionTo(new BinanceSecretState());

        return $this->context->processMessage($message);
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new BinanceSecretState());
    }
}
