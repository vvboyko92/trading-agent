<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NotificationSettingsRepository;

/**
 * @ORM\Entity(repositoryClass=NotificationSettingsRepository::class)
 */
class NotificationSettings
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
    protected $userId;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $chatId;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $pair;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    protected $percentage;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    protected $entryPrice;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    protected $endPrice;

    /**
     * @var boolean|null
     * @ORM\Column(type="boolean")
     */
    protected $isNotified = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $isWatching = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return string|null
     */
    public function getPair(): ?string
    {
        return $this->pair;
    }

    /**
     * @param string|null $pair
     */
    public function setPair(?string $pair): void
    {
        $this->pair = $pair;
    }

    /**
     * @return float|null
     */
    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    /**
     * @param float|null $percentage
     */
    public function setPercentage(?float $percentage): void
    {
        $this->percentage = $percentage;
    }

    /**
     * @return float|null
     */
    public function getEntryPrice(): ?float
    {
        return $this->entryPrice;
    }

    /**
     * @param float|null $entryPrice
     */
    public function setEntryPrice(?float $entryPrice): void
    {
        $this->entryPrice = $entryPrice;
    }

    /**
     * @return float|null
     */
    public function getEndPrice(): ?float
    {
        return $this->endPrice;
    }

    /**
     * @param float|null $endPrice
     */
    public function setEndPrice(?float $endPrice): void
    {
        $this->endPrice = $endPrice;
    }

    /**
     * @return bool|null
     */
    public function getIsNotified(): ?bool
    {
        return $this->isNotified;
    }

    /**
     * @param bool|null $isNotified
     */
    public function setIsNotified(?bool $isNotified): void
    {
        $this->isNotified = $isNotified;
    }

    /**
     * @return bool
     */
    public function isWatching(): bool
    {
        return $this->isWatching;
    }

    /**
     * @param bool $isWatching
     */
    public function setIsWatching(bool $isWatching): void
    {
        $this->isWatching = $isWatching;
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
}
