<?php

namespace NZZ\MyTownBundle\Controller\Admin;


use NZZ\MyTownBundle\Model\PointQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BasePeer;
use Criteria;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\PointPeer;

class AdminPointController extends Controller
{
    public function indexAction($projectId)
    {
        $limit = 1;
        $request = $this->getRequest()->query;
        $page = ($request->get('page')) ? ($request->get('page'))  : 0 ;
        $offset = ($page-1) * $limit;
        $count = PointQuery::create()
            ->joinProject()
            ->filterByProjectid($projectId)
            ->find()->count();
        $points  = PointQuery::create()
            ->joinProject()
            ->filterByProjectid($projectId)
            ->limit($limit)
            ->offset($offset)
            ->orderById(Criteria::DESC)
            ->find()->toArray(null,false,BasePeer::TYPE_FIELDNAME);
        $fields = array(
            'id',
            'Description',
            'Latitude',
            'Longitude',
            'User',
            'User\'s location',
        );

        return $this->render('NZZMyTownBundle:Admin\Point:index.html.twig', array(
                'count' => $count,
                'limit' => $limit,
                'fields' => $fields,
                'points' => $points,
                'projectId' => $projectId,
                'page' => $page
            )
        );
    }

    public function removeAction($pointId)
    {
        $point = PointQuery::create()->findOneById($pointId);

        $point->delete();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_points_dashboard', array('projectId' => $point->getProjectid())));
    }

    public function publishAction($pointId)
    {
        $point = PointQuery::create()->findOneById($pointId);

        $point->setIsPublished(true)->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_points_dashboard', array('projectId' => $point->getProjectid())));
    }

    public function unPublishAction($pointId)
    {
        $point = PointQuery::create()->findOneById($pointId);

        $point->setIsPublished(false)->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_points_dashboard', array('projectId' => $point->getProjectid())));
    }
}
