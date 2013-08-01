<?php

namespace NZZ\AdminMyTownBundle\Form\Type\Projectdata;

use Symfony\Component\Form\FormBuilderInterface;
use Admingenerated\NZZAdminMyTownBundle\Form\BaseProjectdataType\EditType as BaseEditType;

class EditType extends BaseEditType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formOptions = $this->getFormOption('language', array('required' => true,
                'choices' =>   array('de' => 'Deutsch', 'fr' => 'French','en' => 'English'),
                'label' => 'Language',  'translation_domain' => 'Admin',));
        $builder->add('language', 'choice', $formOptions);

        $formOptions = $this->getFormOption('title', array(  'required' => true,  'label' => 'Title',  'translation_domain' => 'Admin',));
        $builder->add('title', 'text', $formOptions);


        $formOptions = $this->getFormOption('description', array(  'required' => false,  'label' => 'Description',  'translation_domain' => 'Admin',));
        $builder->add('description', 'textarea', $formOptions);


        $formOptions = $this->getFormOption('info', array(  'required' => false,  'label' => 'Info',  'translation_domain' => 'Admin',));
        $builder->add('info', 'textarea', $formOptions);


        $formOptions = $this->getFormOption('centerLatitude', array(  'required' => false,  'label' => 'Center\'s longitude',  'translation_domain' => 'Admin',));
        $builder->add('centerLatitude', 'number', $formOptions);


        $formOptions = $this->getFormOption('centerLongitude', array(  'required' => false,  'label' => 'CenterLongitude',  'translation_domain' => 'Admin',));
        $builder->add('centerLongitude', 'number', $formOptions);


        $formOptions = $this->getFormOption('defaultZoom', array(  'required' => false,  'label' => 'Zoom',  'translation_domain' => 'Admin',));
        $builder->add('defaultZoom', 'integer', $formOptions);


        $formOptions = $this->getFormOption('buttonText', array(  'required' => true,  'label' => 'text for Button',  'translation_domain' => 'Admin',));
        $builder->add('buttonText', 'text', $formOptions);

    }
}
