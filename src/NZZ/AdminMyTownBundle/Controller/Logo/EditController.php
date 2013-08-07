<?php

namespace NZZ\AdminMyTownBundle\Controller\Logo;

use Admingenerated\NZZAdminMyTownBundle\BaseLogoController\EditController as BaseEditController;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use NZZ\MyTownBundle\Model\Logo;

class EditController extends BaseEditController
{
    public function preSave(Form $form, Logo $logo)
    {
        $upload = $logo->getContentUploaded();
        if ($upload instanceof UploadedFile) {
            $upload->move($logo->getWebPath(), $upload->getClientOriginalName());
            $logo->setUrl(strtolower($upload->getClientOriginalName()));
        }
    }

    public function updateAction($pk)
    {
        $Logo = $this->getObject($pk);

        if (!$Logo) {
            throw new NotFoundHttpException("The NZZ\MyTownBundle\Model\Logo with Id $pk can't be found");
        }

        $this->preBindRequest($Logo);
        $form = $this->createForm($this->getEditType(), $Logo);
        $form->bind($this->get('request'));

        if ($form->isValid()) {
            try {

                $this->preSave($form, $Logo);
                $this->saveObject($Logo);
                $this->postSave($form, $Logo);

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("action.object.edit.success", array(), 'Admingenerator') );

                if($this->get('request')->request->has('save-and-add'))
                    return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Logo_new" ));
                if($this->get('request')->request->has('save-and-list'))
                    return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Logo_list" ));
                else
                    return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Logo_list" ));

            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error',  $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
                $this->onException($e, $form, $Logo);
            }

        } else {
            $this->get('session')->getFlashBag()->add('error',  $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
        }

        return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Logo_list" ));
    }
}
