<?php

namespace App\Messenger\Telegram;

use App\Entity\TelegramChat;
use App\Messenger\Telegram\State\CancelState;
use App\Messenger\Telegram\State\EraseState;
use App\Messenger\Telegram\State\InitialState;
use App\Messenger\Telegram\State\StartState;
use App\Messenger\Telegram\State\TelegramBotContext;
use App\Messenger\Telegram\State\TelegramState;
use App\TradingApi\Binance;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractTelegramBot
{
    protected HttpClientInterface $telegramClient;
    protected ManagerRegistry $doctrine;
    protected array $webHookRequestData;
    protected Binance $binance;
    protected EventDispatcherInterface $dispatcher;
    protected array $predefinedCommands = [
        '/cancel' => CancelState::class,
        '/erase' => EraseState::class,
    ];

    public function __construct(
        HttpClientInterface $telegramClient,
        ManagerRegistry $doctrine,
        Binance $binance,
        EventDispatcherInterface $dispatcher,
        array $webHookRequestData = [],
    ) {
        $this->telegramClient = $telegramClient;
        $this->doctrine = $doctrine;
        $this->binance = $binance;
        $this->webHookRequestData = $webHookRequestData;
        $this->dispatcher = $dispatcher;
    }

    protected function recordChat(array $query, string $currentState): void
    {
        $telegramChat = new TelegramChat();
        $chatId = $this->webHookRequestData['message']['chat']['id'] ?? $this->webHookRequestData['callback_query']['message']['chat']['id'];
        $telegramChat->setChatId($chatId);
        $userId = $this->webHookRequestData['callback_query']['from']['id'] ?? $this->webHookRequestData['message']['from']['id'];
        $telegramChat->setUserId($userId);
        $telegramChat->setIncomeMessage(json_encode($this->webHookRequestData));
        $telegramChat->setOutcomeMessage(json_encode($query));
        $userInfo = $this->webHookRequestData['callback_query']['from'] ?? $this->webHookRequestData['message']['from'];
        $telegramChat->setUserInfo(json_encode($userInfo));
        $telegramChat->setCurrentState($currentState);
        $em = $this->doctrine->getManager();
        $em->persist($telegramChat);
        $em->flush();
    }

    protected function sendMessage(array $query): void
    {
        $this->telegramClient->request(Request::METHOD_GET, 'sendMessage', [
            'query' => $query
        ]);
    }

    protected function resolveCommand(array $incomingUpdate): void
    {
        if (isset($incomingUpdate['edited_message'])) {
            return;
        }
        $message = $incomingUpdate['message'] ?? $incomingUpdate['callback_query'];
        $command = $message['text'] ?? $message['data'];
        $previousState = $this->getPreviousState($message, $command);
        $state = $previousState ? new $previousState() : new InitialState();
        $context = new TelegramBotContext($state, $this->doctrine->getManager(), $this->binance, $this->dispatcher);
        $context->resolveNextState($command);
        $response = $context->processMessage($message);
        $this->sendMessage($response);
        $this->recordChat($response, $context->getCurrentState());
    }

    protected function getPreviousState(array $message, string $command): ?string
    {
        if (in_array($command, array_keys($this->predefinedCommands))) {
            return $this->predefinedCommands[$command];
        }
        $userId = $message['from']['id'];
        $chatId = $message['chat']['id'] ?? $message['message']['chat']['id'];
        $em = $this->doctrine->getManager();
        $previousMessage = $em->getRepository(TelegramChat::class)->findBy([
            'chatId' => $chatId,
            'userId' => $userId,
        ], [
            'id' => 'DESC'
        ], [1]);

        return isset($previousMessage[0]) ? $previousMessage[0]->getCurrentState() : null;
    }

    public function setWebhook($url): void
    {
        $this->telegramClient->request(Request::METHOD_GET, 'setWebhook', [
            'query' => [
                'url' => $url,
            ],
        ]);
    }

    public function processWebhook(Request $request): void
    {
        $this->webHookRequestData = $request->toArray();
        $this->resolveCommand($this->webHookRequestData);
    }

    public function deleteWebhook(): void
    {
        $this->telegramClient->request(Request::METHOD_GET, 'deleteWebhook', [
            'query' => [
                'drop_pending_updates' => true,
            ],
        ]);
    }
}
