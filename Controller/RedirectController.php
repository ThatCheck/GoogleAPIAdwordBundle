<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 10:00.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends Controller
{
    public function redirectAction(Request $request)
    {
        return $this->render('ThatcheckGoogleAPIAdwordBundle:Redirect:default.html.twig');
    }
}
