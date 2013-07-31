<?php

namespace NZZ\AdminMyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('NZZAdminMyTownBundle:Dashboard:index.html.twig');
    }
}