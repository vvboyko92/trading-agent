<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BinanceApiKeysRepository;

/**
 * @ORM\Entity(repositoryClass=BinanceApiKeysRepository::class)
 */
class BinanceApiKeys
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
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $apiKey;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $apiSecret;

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
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * @param string|null $apiKey
     */
    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string|null
     */
    public function getApiSecret(): ?string
    {
        return $this->apiSecret;
    }

    /**
     * @param string|null $apiSecret
     */
    public function setApiSecret(?string $apiSecret): void
    {
        $this->apiSecret = $apiSecret;
    }
}
