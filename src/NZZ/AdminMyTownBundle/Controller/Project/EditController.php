<?php

namespace NZZ\AdminMyTownBundle\Controller\Project;

use Admingenerated\NZZAdminMyTownBundle\BaseProjectController\EditController as BaseEditController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use NZZ\MyTownBundle\Model\ProjectQuery;

class EditController extends BaseEditController
{
    public function updateAction($pk)
    {
        $project = $this->getObject($pk);



        if (!$project) {
            throw new NotFoundHttpException("The NZZ\MyTownBundle\Model\Project with Id $pk can't be found");
        }

        $this->preBindRequest($project);
        $form = $this->createForm($this->getEditType(), $project);
        $form->bind($this->get('request'));


        if ($form->isValid()) {
            try {
                $this->preSave($form, $project);
                $this->saveObject($project);
                $this->postSave($form, $project);

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("action.object.edit.success", array(), 'Admingenerator') );

                if($this->get('request')->request->has('save-and-add'))
                    return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Project_new" ));
                if($this->get('request')->request->has('save-and-list'))
                    return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Project_list" ));
                else
                    return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Project_list" ));

            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error',  $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
                $this->onException($e, $form, $project);
            }

        } else {
            $this->get('session')->getFlashBag()->add('error',  $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
        }

        return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Project_list" ));
    }
    protected function getObject($pk, $version = null)
    {
        return ProjectQuery::create()->findOneById($pk);
    }
}
