<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller{

    public function contactAction(){
        return $this->render('BlogBundle:Pages:contact.html.twig');
    }

    public function aboutAction(){
        return $this->render('BlogBundle:Pages:about.html.twig');
    }

}