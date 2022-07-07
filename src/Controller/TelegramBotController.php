<?php

namespace App\Controller;

use App\Entity\TelegramChat;
use App\Messenger\Telegram\State\InitialState;
use App\Messenger\Telegram\State\SettingsState;
use App\Messenger\Telegram\TelegramBot;
use App\TradingApi\Binance;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/telegram", name="telegram")
 */
class TelegramBotController extends AbstractController
{
    /**
     * @Route("/set-webhook", name="set_webhook")
     * @param TelegramBot $bot
     * @param Request $request
     * @return Response
     */
    public function setWebhook(TelegramBot $bot, Request $request): Response
    {
        $url = $request->query->get('url');
        $bot->setWebhook($url);

        return new Response();
    }

    /**
     * @Route("/get-webhook", name="get_webhook")
     * @param TelegramBot $bot
     * @param Request $request
     * @return Response
     */
    public function getWebHook(TelegramBot $bot, Request $request): Response
    {
        $bot->processWebhook($request);

        return new Response('true');
    }

    /**
     * @Route("/delete-webhook", name="delete_webhook")
     * @param TelegramBot $bot
     * @param Request $request
     * @return Response
     */
    public function deleteWebHook(TelegramBot $bot, Request $request): Response
    {
        $bot->deleteWebhook();

        return new Response();
    }

    //TODO: Remove next endpoint after webhook will be configured
    /**
     * @Route("/binance", name="binance")
     * @param Binance $binance
     * @return void
     */
    public function binance(Binance $binance, ManagerRegistry $doctrine, EventDispatcherInterface $dispatcher): void
    {
        $text = "symbol: solusdt\n    low: 40\n    tp: 20";
        $stateTest = new SettingsState();
        $stateTest->setDispatcher($dispatcher);
        $stateTest->handleMessage(['text' => $text, 'chat' => ['id' => 1]]);
        $binance->getUserData();
//        $userId = $message['callback_query']['from']['id'] ?? $message['message']['from']['id'];
//        $chatId = $message['message']['chat']['id'] ?? $message['callback_query']['message']['chat']['id'];
        dump(get_class(new InitialState()));
        $em = $doctrine->getManager();
        $messages = $em->getRepository(TelegramChat::class)->findAll();
        dump(get_class(new InitialState()));
        $previousMessage = $em->getRepository(TelegramChat::class)->findBy([
            'chatId' => 447400999,
            'userId' => 447400999,
        ], [
            'id' => 'DESC'
        ], [1]);
        dump($previousMessage);die;
    }

    /**
     * @Route("/binance/notify", name="binance_notify")
     * @param Binance $binance
     * @return void
     */
    public function sendNotification(TelegramBot $bot, Request $request)
    {
        $price = $request->query->get('price');
        $chatId = $request->query->get('chatId');
        $symbol = $request->query->get('symbol');
        $bot->notifyUser($chatId, $price, $symbol);
        dump($price);die;
        return new Response();
    }
}
