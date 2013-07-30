<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

class AdminController extends Controller
{

    public function indexAction()
    {
        return $this->render('NZZMyTownBundle:Admin:index.html.twig', array(
            )
        );

    }
}
