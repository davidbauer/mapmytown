<?php

namespace NZZ\MyTownBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

use BasePeer;
use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\ProjectPeer;
use NZZ\MyTownBundle\Model\ProjectQuery;

class AdminProjectController extends Controller
{
    public function indexAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $projects  = ProjectQuery::create()
            ->find()->toArray(null,false,BasePeer::TYPE_FIELDNAME);
        $projectsFields = ProjectPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        return $this->render('NZZMyTownBundle:Admin\Project:index.html.twig', array(
                'fields' => $projectsFields,
                'projects' => $projects
            )
        );
    }

    public function addAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $project = new Project();
        $form = $this->createFormBuilder($project)
            ->add('title', 'text', array('required' => true))
            ->add('description','text', array('required' => true))
            ->add('centerlatitude','text', array('required' => true))
            ->add('centerlatitude', 'text', array('required' => true))
            ->add('centerlongitude', 'text', array('required' => true))
            ->add('defaultzoom', 'text', array('required' => true))
            ->add('language', 'choice', array('required' => true,
                    'choices'   => array('en' => 'English', 'fr' => 'French', 'de' => 'Deutsch')))
            ->add('save', 'submit')
            ->getForm();

        return $this->render('NZZMyTownBundle:Admin\Project:add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function saveAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $data = $this->getRequest()->get('form');
        if (!empty($data['id'])) {
            $project = ProjectQuery::create()->findOneById($data['id']);
        } else {
            $project  = new Project();
        }
        $project->setTitle($data['title']);
        $project->setDescription($data['description']);
        $project->setCenterlatitude($data['centerlatitude']);
        $project->setCenterlongitude($data['centerlongitude']);
        $project->setDefaultzoom($data['defaultzoom']);
        $project->setLanguage($data['language']);
        $project->save();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_dashboard'));
    }

    public function editProjectAction($projectId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $project = ProjectQuery::create()->findOneById($projectId);
        $form = $this->createFormBuilder($project)
            ->add('id','text',array('read_only' => true))
            ->add('title', 'text', array('required' => true))
            ->add('description', 'textarea', array('required' => true))
            ->add('centerlatitude', 'text', array('required' => true))
            ->add('centerlatitude', 'text', array('required' => true))
            ->add('centerlongitude', 'text', array('required' => true))
            ->add('defaultzoom', 'text', array('required' => true))
            ->add('language', 'choice', array('required' => true,
                    'choices'   => array('en' => 'English', 'fr' => 'French', 'de' => 'Deutsch')))
            ->add('save', 'submit')
            ->getForm();

        return $this->render('NZZMyTownBundle:Admin\Project:editProject.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function removeProjectAction($projectId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $project = ProjectQuery::create()->findOneById($projectId);
        $project->delete();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_dashboard'));
    }

}
