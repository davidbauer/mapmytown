<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

class ApiController extends Controller
{

    public function saveAction($project)
    {
        $request = $this->getRequest();
        $parameters = $request->request->all();
        if (!empty($parameters)) {

        }
        var_dump($parameters);die;
    }
}
