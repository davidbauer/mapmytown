<?php

namespace VFE\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($project,$lang,$zoom)
    {
        return $this->render('VFEMyTownBundle:Default:index.html.twig', array(
                'project' => $project,
                'lang' => $lang,
                'zoom' => $zoom,
            )
        );
    }
}
