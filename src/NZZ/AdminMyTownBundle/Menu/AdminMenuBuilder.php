<?php

namespace NZZ\AdminMyTownBundle\Menu;

use Admingenerator\GeneratorBundle\Menu\AdmingeneratorMenuBuilder;
use Knp\Menu\FactoryInterface;

class AdminMenuBuilder extends AdmingeneratorMenuBuilder
{
    protected $translation_domain = 'Admin';

    public function navbarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('id' => 'main_navigation', 'class' => 'nav'));

        return $menu;
    }
}
