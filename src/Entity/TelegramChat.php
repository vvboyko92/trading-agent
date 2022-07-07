<?php

namespace App\Entity;

use App\Repository\TelegramChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TelegramChatRepository::class)
 */
class TelegramChat
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $chatId;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $userId;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $userInfo;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $incomeMessage;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $outcomeMessage;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $currentState;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @param int $chatId
     */
    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    /**
     * @param string $userInfo
     */
    public function setUserInfo(string $userInfo): void
    {
        $this->userInfo = $userInfo;
    }

    /**
     * @return string
     */
    public function getIncomeMessage(): string
    {
        return $this->incomeMessage;
    }

    /**
     * @param string $incomeMessage
     */
    public function setIncomeMessage(string $incomeMessage): void
    {
        $this->incomeMessage = $incomeMessage;
    }

    /**
     * @return string
     */
    public function getOutcomeMessage(): string
    {
        return $this->outcomeMessage;
    }

    /**
     * @param string $outcomeMessage
     */
    public function setOutcomeMessage(string $outcomeMessage): void
    {
        $this->outcomeMessage = $outcomeMessage;
    }

    /**
     * @return string|null
     */
    public function getCurrentState(): ?string
    {
        return $this->currentState;
    }

    /**
     * @param string $currentState
     */
    public function setCurrentState(string $currentState): void
    {
        $this->currentState = $currentState;
    }
}
