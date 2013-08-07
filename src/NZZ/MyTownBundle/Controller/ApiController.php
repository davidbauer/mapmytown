<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\ProjectDataQuery;
use NZZ\MyTownBundle\Model\PointQuery;
use NZZ\MyTownBundle\Model\Point;
use BasePeer;
use Criteria;

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
            ->filterByLanguage($lang)
            ->findOne();

        if (!$projectData) {

            $projectData = ProjectDataQuery::create()
                ->filterByprojectId($project->getId())
                ->filterByLanguage($project->getDefaultLanguage())
                ->findOne();

            if (!$projectData) {
                return new Response('No data found for specified project', 404);
            }
        }

        $points = PointQuery::create()
            ->filterByIsPublished(true)
            ->orderById(Criteria::DESC)
            ->findByProjectid($project->getId());

        $response = array(
            'project' => array_merge(
                $project->toArray(),
                $projectData->toArray(),
                array('points' => $points->toArray(null, false, BasePeer::TYPE_STUDLYPHPNAME))
            )
        );

        return new JsonResponse($response);

    }

    public function saveAction($projectSlug)
    {
        $request = $this->getRequest();
        $parameters = $request->request->all();
        if (empty($parameters['title']) || empty($parameters['description']) || !in_array($parameters['sentiment'], array('-1', '0', '1')) || empty($parameters['latitude']) || empty($parameters['longitude'])) {
            return new Response('Not enough data for save action', 500);
        }

        $project = ProjectQuery::create()->findOneBySlug($projectSlug);

        if (!$project) {
            return new Response('No such project', 500);
        }

        $point = new Point();
        $point->setProjectid($project->getId());
        $point->setTitle($parameters['title']);
        $point->setDescription($parameters['description']);
        $point->setSentiment($parameters['sentiment']);
        $point->setLatitude($parameters['latitude']);
        $point->setLongitude($parameters['longitude']);
        $point->setAuthorName($parameters['authorName']);
        $point->setAuthorLocation($parameters['authorLocation']);
        $point->setIsPublished(true);

        try {
            $point->save();
        } catch (\PropelException $e) {
            return new Response('Exception while saving data', 500);
        }

        return new Response('', 200);
    }
}
