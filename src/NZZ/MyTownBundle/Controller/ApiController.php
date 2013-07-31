<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\ProjectDataQuery;
use NZZ\MyTownBundle\Model\PointQuery;

class ApiController extends Controller
{

    public function indexAction($projectSlug, $lang)
    {
        $project = ProjectQuery::create()->findOneBySlug($projectSlug);

        if (!$project) {
            return new Response('No such project', 404);
        }

        $projectData = ProjectDataQuery::create()
            ->filterByprojectId($project->getId())
            ->find();

        if ($projectData) {

            $translatedData = $projectData->filterByLanguage($lang);

            if (!$translatedData) {
                $translatedData = $projectData->filterByLanguage($project->getDefaultLanguage());
            }

            $points = PointQuery::create()->findByProjectid($project->getId());

            $response = array(
                'project' => array_merge(
                    $project->toArray(),
                    $translatedData->toArray(),
                    array('points' => $points->toArray()))
            );

        } else {
            return new Response('No data found for specified project', 404);
        }

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
