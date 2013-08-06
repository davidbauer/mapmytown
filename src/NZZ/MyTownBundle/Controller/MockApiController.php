<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MockApiController extends Controller
{

    public function indexAction($projectSlug, $lang)
    {
        return $this->render('NZZMyTownBundle:Mockdata:project.json.twig');
    }

    public function saveAction($projectSlug)
    {
        return new Response('', 200);
    }
}
