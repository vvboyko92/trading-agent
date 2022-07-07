<?php

namespace App\Messenger\Telegram\NotificationBuilder;

class NotificationBuilder implements NotificationBuilderInterface
{
    private Notification $notification;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->notification = new Notification();
    }
    public function addSymbol(array $symbol): void
    {
        $this->notification->symbol = $symbol['value'];
    }

    public function addLow(array $low): void
    {
        $this->notification->low = $low;
    }

    public function addTp(array $tp): void
    {
        $this->notification->tp = $tp;
    }

    public function getNotification(): Notification
    {
        $result = $this->notification;
        $this->reset();

        return $result;
    }
}
