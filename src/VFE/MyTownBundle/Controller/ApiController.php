<?php

namespace VFE\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Predis\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;
use VFE\MyTownBundle\Redis\RedisClientProvider;

class ApiController extends Controller
{
    /** @var Client $readClient */
    private $readClient;

    /** @var Client $readClient */
    private $writeClient;

    public function saveAction($project)
    {
        $redisClientProvider = $this->get('vfe_my_town.redis_client_provider');
        $this->readClient = $redisClientProvider->getReadClient();
        $this->writeClient = $redisClientProvider->getWriteClient();
        $request = $this->getRequest();
        $parameters = $request->request->all();
        if (!empty($parameters)) {

        }
        var_dump($parameters);die;
  return new JsonResponse($parameters);
//        $this->writeClient->hset(
//            $project . ':' . 1
//        );

    }
}
