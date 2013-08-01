<?php

namespace NZZ\AdminMyTownBundle\Form\Type\Project;

use Admingenerated\NZZAdminMyTownBundle\Form\BaseProjectType\EditType as BaseEditType;

use Symfony\Component\Form\FormBuilderInterface;

class EditType extends BaseEditType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $formOptions = $this->getFormOption('slug', array(  'required' => true,  'label' => 'Slug',  'translation_domain' => 'Admin',));
        $builder->add('slug', 'text', $formOptions);


        $formOptions = $this->getFormOption('defaultzoom', array(  'required' => true,  'label' => 'Zoom by default',  'translation_domain' => 'Admin',));
        $builder->add('defaultzoom', 'integer', $formOptions);


        $formOptions = $this->getFormOption('defaultlanguage', array(  'required' => true,
                'choices' =>   array('de' => 'Deutsch', 'fr' => 'French','en' => 'English'),
                 'label' => 'Language by default',  'translation_domain' => 'Admin',));
        $builder->add('defaultlanguage', 'choice', $formOptions);


        $formOptions = $this->getFormOption('project_data', array(  'allow_add' => true,  'allow_delete' => true,  'by_reference' => true,  'type' => new ProjectdataEditType(),  'error_bubbling' => true,  'required' => false,  'options' =>   array('attr' => array('class'=>'span4'),  'required' => false, 'data_class' => 'NZZ\\MyTownBundle\\Model\\ProjectData',  ), 'translation_domain' => 'Admin',));
        $builder->add('project_data', 'collection', $formOptions);


    }
}
