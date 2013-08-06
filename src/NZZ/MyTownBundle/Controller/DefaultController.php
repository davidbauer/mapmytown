<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($project,$lang)
    {
        return $this->render('NZZMyTownBundle:Default:index.html.twig', array(
                'project' => $project,
                'lang' => $lang
            )
        );
    }
}
