<?php

namespace MatM\Bundle\TypeAheadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MatMTypeAheadBundle:Default:index.html.twig', array('name' => $name));
    }
}
