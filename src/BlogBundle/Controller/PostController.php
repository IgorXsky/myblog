<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class PostController extends Controller
{
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $posts = $repository->findPosts();

        return $this->render('BlogBundle:Post:list.html.twig', array(
            'posts' => $posts
        ));
    }

    public function postAction()
    {
        return $this->render('BlogBundle:Post:post.html.twig', array(
            // ...
        ));
    }

}
