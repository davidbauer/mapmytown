<?php

namespace NZZ\AdminMyTownBundle\Controller\Point;

use Admingenerated\NZZAdminMyTownBundle\BasePointController\ShowController as BaseShowController;

class ShowController extends BaseShowController
{
    public function indexAction($pk)
    {
     var_dump('ololo');die;
        $Point = $this->getObject($pk);



        if (!$Point) {
            throw new NotFoundHttpException("The NZZ\MyTownBundle\Model\Point with Id $pk can't be found");
        }

        return $this->render('NZZAdminMyTownBundle:PointShow:index.html.twig', $this->getAdditionalRenderParameters($Point) + array(
                "Point" => $Point
            ));
    }
}
