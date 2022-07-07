<?php

namespace App\Messenger\Telegram\NotificationBuilder;

interface NotificationBuilderInterface
{
    public function addSymbol(array $symbol): void;
    public function addLow(array $low): void;
    public function addTp(array $tp): void;
}
