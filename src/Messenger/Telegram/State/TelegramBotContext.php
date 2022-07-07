<?php

namespace App\Messenger\Telegram\State;

use App\TradingApi\Binance;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class TelegramBotContext
{
    private TelegramState $state;
    private ObjectManager $em;
    private Binance $binance;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        TelegramState $state,
        ObjectManager $em,
        Binance $binance,
        EventDispatcherInterface $dispatcher
    ) {
        $this->em = $em;
        $this->binance = $binance;
        $this->dispatcher = $dispatcher;
        $this->transitionTo($state);
    }

    public function transitionTo(TelegramState $state): void
    {
        $this->state = $state;
        $this->state->setEntityManager($this->em);
        $this->state->setBinanceService($this->binance);
        $this->state->setDispatcher($this->dispatcher);
        $this->state->setContext($this);
    }

    public function processMessage(array $message): array
    {
        return $this->state->handleMessage($message);
    }

    public function resolveNextState($command): void
    {
        $this->state->resolveNextState($command);
    }

    public function getCurrentState(): string
    {
        return get_class($this->state);
    }
}
