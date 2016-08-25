<?php

namespace BlogBundle\Controller;


use BlogBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Form\CommentType;
use BlogBundle\Form\PostType;


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

    public function postAction($id)
    {
        $post = $this->getDoctrine()->getEntityManager()->getRepository('BlogBundle:Post')->find($id);

        $comment = new Comment();
        $comment -> setPostId($id);

        $form = $this->createForm('BlogBundle\Form\CommentType', $comment);

        return $this->render('BlogBundle:Post:post.html.twig', array(
            'post' => $post,
            'form' => $form->createView()
        ));
    }

    public function saveCommentAction(Request $request){
        $comment = new Comment();
        $form = $this->createForm('BlogBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getEntityManager();
        $manager->persist($comment);
        $manager->flush();

        return new Response();
    }

}
