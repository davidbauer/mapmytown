<?php

namespace NZZ\MyTownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\ProjectDataQuery;
use NZZ\MyTownBundle\Model\LogoQuery;
use NZZ\MyTownBundle\Model\Logo;

class ImageController extends Controller
{

    public function indexAction($filename)
    {
        /** @var Logo $logo */
        $logo = LogoQuery::create()
                ->filterByUrl($filename)
                ->findOne();

        if (!$logo) {
            return new Response('No such image', 404);
        }

        $image = file_get_contents($logo->getWebPath().$filename);

        return new Response($image, 200, array('Content-Type' => 'image/png'));

    }


}
