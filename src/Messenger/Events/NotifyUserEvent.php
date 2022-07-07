<?php

namespace App\Messenger\Events;

use Symfony\Contracts\EventDispatcher\Event;

class NotifyUserEvent extends Event
{
    public const NAME = 'notify.user';

    protected array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }
}
