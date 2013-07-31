<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\PointQuery;

class ApiController extends Controller
{

    public function indexAction($projectShortname, $lang)
    {
        $project = ProjectQuery::create()->findOneByShortname($projectShortname);

        if (!$project) {
            return new Response('No such project', 404);
        }

        $points = PointQuery::create()->findByProjectid($project->getId());

        $response = array(
            'project' => $project->toArray(),
            'points' => $points->toArray()
        );

        return new JsonResponse($response);

    }

    public function saveAction($project)
    {
        $request = $this->getRequest();
        $parameters = $request->request->all();
        if (!empty($parameters)) {

        }
//        var_dump($parameters);die;
    }
}
