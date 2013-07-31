<?php

namespace NZZ\MyTownBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

use Criteria;
use BasePeer;
use NZZ\MyTownBundle\Model\PointPeer;
use NZZ\MyTownBundle\Model\PointQuery;
use NZZ\MyTownBundle\Model\ProjectQuery;

class AdminPointController extends Controller
{
    public function indexAction($projectId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $limit = $this->container->getParameter('point_limit');
        $request = $this->getRequest()->query;
        $page = ($request->get('page')) ? ($request->get('page')) : 1 ;
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
            'Sentiment'
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
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $point = PointQuery::create()->findOneById($pointId);

        $point->delete();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_points_dashboard', array('projectId' => $point->getProjectid())));
    }

    public function publishAction($pointId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $point = PointQuery::create()->findOneById($pointId);

        $point->setIsPublished(true)->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_points_dashboard', array('projectId' => $point->getProjectid())));
    }

    public function unPublishAction($pointId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $point = PointQuery::create()->findOneById($pointId);

        $point->setIsPublished(false)->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_points_dashboard', array('projectId' => $point->getProjectid())));
    }
}
