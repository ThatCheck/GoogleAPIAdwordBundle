<?php

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ThatcheckGoogleAPIAdwordBundle:Default:index.html.twig', array('name' => $name));
    }
}
