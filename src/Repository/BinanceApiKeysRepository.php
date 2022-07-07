<?php

namespace App\Repository;

use App\Entity\BinanceApiKeys;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BinanceApiKeysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BinanceApiKeys::class);
    }

    public function getApiKeys($userId)
    {
        return $this->findOneBy(['userId' => $userId]);
    }
}
