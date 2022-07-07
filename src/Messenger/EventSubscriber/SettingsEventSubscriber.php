<?php

namespace App\Messenger\EventSubscriber;

use App\Messenger\Events\NotifyUserEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SettingsEventSubscriber implements EventSubscriberInterface
{
    private HttpClientInterface $httpClient;
    private string $tradingMonitor;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $parameterBag)
    {
        $this->httpClient = $client;
        $this->tradingMonitor = $parameterBag->get('TRADING_MONITOR_API_HOST').'/api/binance/notify';
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotifyUserEvent::NAME => 'onFinishSettings'
        ];
    }

    public function onFinishSettings(NotifyUserEvent $event)
    {
        $settings = $event->getSettings();
        $this->httpClient->request(Request::METHOD_GET, $this->tradingMonitor, [
            'json' => $settings,
        ]);
    }
}
