<?php

namespace App\Messenger\Telegram\State;

use App\Entity\BinanceApiKeys;

// TODO: This flow is not finished yet. I need to rethink how to implement this part.
// in this flow we should select opened positions and orders to define percentage that we want to earn
// but user can have a dozen of open orders and positions. This is the issue at the moment!
class SelectPositionState extends TelegramState
{
    protected array $positions = [
        '/manual' => [
            'class' => ManualState::class,
            'name' => "\xE2\x9C\x8C".'Manual',
        ],
        '/automatic' => [
            'class' => AutomaticState::class,
            'name' => "\xF0\x9F\x94\x91".'Automatic',
        ]
    ];
    public function handleMessage(array $message): array
    {
        $userId = $message['from']['id'];
        $repository = $this->entityManager->getRepository(BinanceApiKeys::class);
        /** @var BinanceApiKeys $apiKeys */
        $apiKeys = $repository->getApiKeys($userId);
    }

    public function resolveNextState(string $command): void
    {
        // TODO: Implement resolveNextState() method.
    }

    private function getBinancePositions(): string
    {
        $type = [];
        $this->binance->getUserData();
        foreach ($this->positions as $command => $type) {
            $type[] = [
                'text' => $type['name'],
                'callback_data' => $command,
            ];
        }
        return json_encode([
            "inline_keyboard" => [$type]
        ]);
    }
}
