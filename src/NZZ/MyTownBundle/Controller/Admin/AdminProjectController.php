<?php

namespace NZZ\MyTownBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Tests\Constraints\CallbackValidatorTest_Class;

use BasePeer;
use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\ProjectData;
use NZZ\MyTownBundle\Model\ProjectDataQuery;

class AdminProjectController extends Controller
{
    public function indexAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $projects  = ProjectQuery::create()
            ->find()->toArray(null,false,BasePeer::TYPE_FIELDNAME);
        $projectsFields = array('id', 'slug', 'defaultZoom', 'defaultLanguage' );

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
            ->add('slug', 'text', array('required' => true))
            ->add('defaultzoom', 'text', array('required' => true))
            ->add('defaultlanguage', 'choice', array('required' => true,
                'choices'   => array('de' => 'Deutsch','fr' => 'French', 'en' => 'English')))
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
            $this->saveProjectData($data);
        } else {
            $project  = new Project();
            $project->setSlug($data['slug']);
            $project->setDefaultzoom($data['defaultzoom']);
            $project->setDefaultlanguage($data['defaultlanguage']);

            $project->save();
        }

        return $this->redirect($this->generateUrl('nzz_my_town_admin_dashboard'));
    }

    private function saveProjectData($data)
    {
        /** @var  $projectData ProjectData*/
        $projectData = ProjectDataQuery::create()
            ->filterByprojectId($data['projectId'])
            ->filterByLanguage($data['language'])
            ->findOne();

        if ($projectData) {
            $projectData->setTitle($data['title']);
            $projectData->setDescription($data['description']);
            $projectData->setInfo($data['info']);
            $projectData->setCenterlongitude($data['centerlongitude']);
            $projectData->setCenterlatitude($data['centerlatitude']);
            $projectData->setDefaultzoom($data['defaultzoom']);
            $projectData->setLanguage($data['language']);
            $projectData->save();
        }

    }
    public function editProjectAction($projectId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $request = $this->getRequest()->query;
        $project = ProjectQuery::create()->findOneById($projectId);
        $lang = ($request->get('lang')) ? ($request->get('lang')) : $project->getDefaultlanguage() ;
        /** @var  $projectData ProjectData*/
        $projectData = ProjectDataQuery::create()
            ->filterByLanguage($lang)
            ->filterByprojectId($project->getId())
            ->findOneOrCreate();
        $zoom = $projectData->getDefaultzoom();
        if (empty($zoom)) {
            $zoom = $project->getDefaultzoom();
        }
        $language = $projectData->getLanguage();
        if (empty($language)) {
            $language = $project->getDefaultlanguage();
        }

        $form = $this->createFormBuilder($projectData)
            ->add('id','text', array('read_only' => true))
            ->add('language', 'choice', array('required' => true,'data' => $language,
                    'choices'   => array( 'de' => 'Deutsch', 'en' => 'English', 'fr' => 'French')
                ))
            ->add('title', 'text', array('required' => true, 'data' => $projectData->getTitle()))
            ->add('description', 'textarea', array('required' => true, 'data' => $projectData->getDescription()))
            ->add('info', 'textarea', array('required' => false, 'data' => $projectData->getInfo()))
            ->add('centerlatitude', 'text', array('required' => true, 'data' => $projectData->getCenterlatitude()))
            ->add('centerlongitude', 'text', array('required' => true, 'data' => $projectData->getCenterlongitude()))
            ->add('defaultzoom', 'text', array('required' => true, 'data' => $zoom))
            ->add('save', 'submit')
            ->add('remove', 'button')
            ->add('projectId','hidden', array('data' => $project->getId()))
            ->getForm();

        return $this->render('NZZMyTownBundle:Admin\Project:editProject.html.twig', array(
                'form' => $form->createView(),
                'projectId' => $projectId
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

    public function removeProjectDataAction($projectId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $lang = ($this->getRequest()->get('lang')) ? ($this->getRequest()->get('lang')): '';

        $projectData = ProjectDataQuery::create()
            ->filterByLanguage($lang)
            ->filterByprojectId($projectId)
            ->findOne();

        $projectData->delete();

        return $this->redirect($this->generateUrl('nzz_my_town_admin_dashboard'));
    }

}
