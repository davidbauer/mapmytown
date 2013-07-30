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
        $points  = PointQuery::create()
            ->joinProject()
            ->filterByProjectid($projectId)
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
                'fields' => $fields,
                'points' => $points
            )
        );
    }

    public function addAction()
    {
//        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
//            return $this->redirect($this->generateUrl('vfe_emotion_homepage'));
//        }
        $project = new Project();
        $form = $this->createFormBuilder($project)
            ->add('name', 'text', array('required' => true))
            ->add('shortname','text', array('required' => true))
            ->add('centerlatitude','text', array('required' => true))
            ->add('centerlatitude', 'text', array('required' => true))
            ->add('centerlongitude', 'text', array('required' => true))
            ->add('defaultzoom', 'text', array('required' => true))
            ->add('language', 'choice', array('required' => true,
                    'choices'   => array('en' => 'English', 'fr' => 'French', 'de' => 'Deutsch')))
            ->add('save', 'submit')
            ->getForm();

        return $this->render('NZZMyTownBundle:Admin:add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function saveAction()
    {
        $data = $this->getRequest()->get('form');
        if (!empty($data['id'])) {
            $project = ProjectQuery::create()->findOneById($data['id']);
        } else {
            $project  = new Project();
        }
        $project->setName($data['name']);
        $project->setShortname($data['shortname']);
        $project->setCenterlatitude($data['centerlatitude']);
        $project->setCenterlongitude($data['centerlongitude']);
        $project->setDefaultzoom($data['defaultzoom']);
        $project->setLanguage($data['language']);
        $project->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_dashboard'));
    }


    public function editProjectAction($projectId)
    {
        $project = ProjectQuery::create()->findOneById($projectId);
        $form = $this->createFormBuilder($project)
            ->add('id','text',array('read_only' => true))
            ->add('name', 'text', array('required' => true))
            ->add('shortname', 'text', array('required' => true))
            ->add('centerlatitude', 'text', array('required' => true))
            ->add('centerlatitude', 'text', array('required' => true))
            ->add('centerlongitude', 'text', array('required' => true))
            ->add('defaultzoom', 'text', array('required' => true))
            ->add('language', 'choice', array('required' => true,
                    'choices'   => array('en' => 'English', 'fr' => 'French', 'de' => 'Deutsch')))
            ->add('save', 'submit')
            ->getForm();

        return $this->render('NZZMyTownBundle:Admin:editProject.html.twig', array(
                'form' => $form->createView()
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
