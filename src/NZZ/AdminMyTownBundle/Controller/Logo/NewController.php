<?php

namespace NZZ\AdminMyTownBundle\Controller\Logo;

use Admingenerated\NZZAdminMyTownBundle\BaseLogoController\NewController as BaseNewController;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use NZZ\MyTownBundle\Model\Logo;

class NewController extends BaseNewController
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
