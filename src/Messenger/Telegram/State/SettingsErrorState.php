<?php

namespace App\Messenger\Telegram\State;

class SettingsErrorState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        $generalCurrencies = new GeneralCurrenciesState();
        $instructions = $generalCurrencies->handleMessage($message);
        $instructions['text'] = "\xE2\x9A\xA0".$message['error'] .'
'. $instructions['text'];
        return $instructions;
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new SettingsState());
    }

}
