<?php

namespace App\Messenger\Telegram\State;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class BinanceState extends TelegramState
{
    protected array $type = [
        '/manual' => [
            'class' => ManualState::class,
            'name' => "\xE2\x9C\x8C".'Manual',
        ],
        '/automatic' => [
            'class' => CommandNotFoundException::class,
//            'class' => AutomaticState::class,
            'name' => "\xF0\x9F\x94\x91".'Automatic',
        ]
    ];

    #[ArrayShape(['chat_id' => "mixed", 'reply_markup' => "string", 'text' => "string"])]
    public function handleMessage(array $message): array
    {
        return [
            'chat_id' => $message['message']['chat']['id'] ?? $message['chat']['id'],
            'reply_markup' => $this->getListOfTypes(),
            'text' => 'Choose the type of signal!'
        ];
    }

    public function resolveNextState(string $command): void
    {
        $currencyClass = $this->type[$command]['class'] ?? GeneralCurrenciesState::class;
        $this->context->transitionTo(new $currencyClass());
    }

    private function getListOfTypes(): string
    {
        $type = [];
        foreach ($this->type as $command => $option) {
            $type[] = [
                'text' => $option['name'],
                'callback_data' => $command,
            ];
        }
        return json_encode([
            "inline_keyboard" => [$type]
        ]);
    }
}
