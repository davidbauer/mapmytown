<?php

namespace NZZ\MyTownBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BasePeer;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

use NZZ\MyTownBundle\Model\ProjectsQuery;
use NZZ\MyTownBundle\Model\Projects;
use NZZ\MyTownBundle\Model\ProjectsPeer;

class AdminController extends Controller
{
    public function indexAction()
    {
        $projects  = ProjectsQuery::create()
            ->find()->toArray(null,false,BasePeer::TYPE_FIELDNAME);
        $projectsFields = ProjectsPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        return $this->render('NZZMyTownBundle:Admin:index.html.twig', array(
                'fields' => $projectsFields,
                'projects' => $projects
            )
        );
    }

    public function addAction()
    {
//        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
//            return $this->redirect($this->generateUrl('vfe_emotion_homepage'));
//        }
        $projectsFields = ProjectsPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        $project = new Projects();
        $form = $this->createFormBuilder($project)
            ->add('name')
            ->add('shortname')
            ->add('centerlatitude')
            ->add('centerlatitude')
            ->add('centerlongitude')
            ->add('defaultzoom')
            ->add('language')
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
        $project  = new Projects();
        $project->setName($data['name']);
        $project->setShortname($data['shortname']);
        $project->setCenterlatitude($data['centerlatitude']);
        $project->setCenterlongitude($data['centerlongitude']);
        $project->setDefaultzoom($data['defaultzoom']);
        $project->setLanguage($data['language']);
        $project->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_dashboard'));
    }


    public function editAction($projectId)
    {
        return $this->render('NZZMyTownBundle:Admin:index.html.twig', array(
            )
        );
    }

    public function removeAction($projectId)
    {
        return $this->render('NZZMyTownBundle:Admin:index.html.twig', array(
            )
        );
    }
}
