<?php

namespace NZZ\AdminMyTownBundle\Controller\Logo;

use Admingenerated\NZZAdminMyTownBundle\BaseLogoController\EditController as BaseEditController;

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
}
