<?php

namespace App\Messenger\Telegram\State;

use App\TradingApi\Binance;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

abstract class TelegramState
{
    protected TelegramBotContext $context;
    protected ObjectManager $entityManager;
    protected Binance $binance;
    protected EventDispatcherInterface $dispatcher;

    public function setContext(TelegramBotContext $context): void
    {
        $this->context = $context;
    }

    abstract public function handleMessage(array $message): array;

    abstract public function resolveNextState(string $command): void;

    public function setEntityManager(ObjectManager $objectManager): void
    {
        $this->entityManager = $objectManager;
    }

    public function setBinanceService(Binance $binance): void
    {
        $this->binance = $binance;
    }

    public function setDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }
}
