<?php

namespace SearchengineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Searchengine/Default/index.html.twig');
    }
}
