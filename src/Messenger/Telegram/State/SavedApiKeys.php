<?php

namespace App\Messenger\Telegram\State;

use App\Entity\BinanceApiKeys;
use App\Repository\BinanceApiKeysRepository;

class SavedApiKeys extends TelegramState
{
    public function handleMessage(array $message): array
    {
        /** @var BinanceApiKeysRepository $repository */
        $repository = $this->entityManager->getRepository(BinanceApiKeys::class);
        $userId = $message['from']['id'];
        /** @var BinanceApiKeys $apiKeys */
        $apiKeys = $repository->getApiKeys($userId);
        if ($apiKeys && !$apiKeys->getApiSecret()) {
            $apiKeys->setApiSecret($message['message']['text'] ?? $message['text']);
            $this->entityManager->flush();
        }

        $this->context->transitionTo(new SelectPositionState());

        return $this->context->processMessage($message);
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new SelectPositionState());
    }

}
