<?php

namespace App\Messenger\Telegram\State;


class StartState extends TelegramState
{
    protected array $platformStates = [
        '/binance' => [
            'class' => BinanceState::class,
            'name' => 'Binance',
        ]
    ];

    public function handleMessage(array $message): array
    {
        $user = $message['from']['first_name'] ?? $message['from']['username'];
        $text = 'Hello {user}! Please choose the trading platform!';
        $text = str_replace('{user}', $user, $text);

        return [
            'chat_id' => $message['chat']['id'] ?? $message['message']['chat']['id'],
            'reply_markup' => $this->getListOfTradingPlatforms(),
            'text' => $text
        ];
    }

    public function resolveNextState($command): void
    {
        $platform = $this->platformStates[$command]['class'] ?? NotFoundState::class;
        $this->context->transitionTo(new $platform());
    }

    private function getListOfTradingPlatforms(): string
    {
        $platformChoices = [];
        foreach ($this->platformStates as $command => $platformInfo) {
            $platformChoices[] = [
                'text' => "\xF0\x9F\x8F\xAC" . $platformInfo['name'],
                'callback_data' => $command,
            ];
        }

        return json_encode([
            "inline_keyboard" => [$platformChoices]
        ]);
    }
}
