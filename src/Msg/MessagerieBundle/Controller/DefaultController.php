<?php

namespace Msg\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MsgMessagerieBundle:Default:index.html.twig');
    }
}
