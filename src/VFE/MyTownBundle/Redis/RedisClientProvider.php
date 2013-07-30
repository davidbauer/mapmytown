<?php

namespace VFE\MyTownBundle\Redis;

use Predis\Client;

class RedisClientProvider
{
    /** @var Client $readClient */
    private $readClient;

    /** @var Client $writeClient */
    private $writeClient;

    /**
     * Provides one read and one write client
     * @param Client $writeClient
     */
    public function __construct(Client $writeClient)
    {
        $this->writeClient = $writeClient;
        $this->readClient  = $writeClient;
    }

    public function getReadClient()
    {
        return $this->readClient;
    }

    public function getWriteClient()
    {
        return $this->writeClient;
    }
}
