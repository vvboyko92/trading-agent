<?php

namespace App\Messenger\Telegram\NotificationBuilder;

class Notification
{
    public string $symbol;
    public array $low = [];
    public array $tp = [];
    public int $chatId;

    public function toJson(): string
    {
        $result = [];
        $classProps = get_class_vars(static::class);
        foreach (array_keys($classProps) as $propName) {
            $propValue = $this->{$propName};
            if (!$propValue) {
                continue;
            }
            $result[$propName] = $propValue;
        }

        return json_encode($result);
    }
}
