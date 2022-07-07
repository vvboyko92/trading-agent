<?php

namespace App\Messenger\Telegram\State;

class GeneralCurrenciesState extends TelegramState
{
    public function handleMessage(array $message): array
    {
        $commandExample = "";
        $legendDescription = "";
        foreach (SettingsState::VALIDATION_MAP as $key => $settings) {
            $commandExample .= $key.": ". $settings['exampleValue'] . "\n";
            $legendDescription .= "<i>" . $key . "</i> - " . $settings['description'] . "\n";
        }

        //Unfortunately formatting of text code is not possible, because all the spaces(tabs) will be
        //treated as spaces in the message and the result will be a bit ugly.
        return [
            'chat_id' => $message['chat']['id'] ?? $message['message']['chat']['id'],
            'parse_mode' => 'HTML',
            'text' => "Please enter currency pair and percentage to notify in next format
<pre>$commandExample</pre>
<b>Legend</b>:
$legendDescription",
        ];
    }

    public function resolveNextState(string $command): void
    {
        $this->context->transitionTo(new SettingsState());
    }

}
