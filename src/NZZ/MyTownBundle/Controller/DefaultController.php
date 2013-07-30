<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\PointQuery;

class DefaultController extends Controller
{
    public function indexAction($projectShortname, $lang, $zoom = null)
    {
        $project = ProjectQuery::create()->findOneByShortname($projectShortname);

        if (!$project) {
            return new Response('No such project', 404);
        }

        if (!$zoom) {
            $zoom = $project->getDefaultzoom();
        }

        $points = PointQuery::create()->findByProjectid($project->getId());

        return new JsonResponse($points);

    }
}
