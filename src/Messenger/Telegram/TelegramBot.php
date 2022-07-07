<?php

namespace App\Messenger\Telegram;

use App\Entity\TelegramChat;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramBot extends AbstractTelegramBot
{
    public function notifyUser($chatId, $price, $symbol): void
    {
        $text = 'The ' . strtoupper($symbol) . ' price is ' . $price;
        $this->sendMessage([
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }
}
