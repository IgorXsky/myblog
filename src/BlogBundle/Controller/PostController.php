<?php

namespace BlogBundle\Controller;


use BlogBundle\Entity\Comment;
use BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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

    public function createAction(Request $request){

        $session = new Session();
        $user = $session->get("user");

        if($user){
            $post = new Post();
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);

            if($form->isSubmitted()){
                $post->setCreatedAt(new \DateTime());
                $this->getDoctrine()->getManager()->persist($post);
                $this->getDoctrine()->getManager()->flush();
            }
            return $this->render('BlogBundle:Post:create.html.twig', array(
                'form' => $form->createView()
            ));
        }else{
            return $this->render('BlogBundle:User:login.html.twig', array());
        }

    }

    public function saveCommentAction(Request $request){
        $comment = new Comment();
        $form = $this->createForm('BlogBundle\Form\CommentType', $comment);
        $form->handleRequest($request);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BlogBundle:Post');
        $post = $repository->find($_POST['comment']['postId']);

        $comment->setPost($post);

        $manager = $this->getDoctrine()->getEntityManager();
        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute(
            'BlogBundle_post', ['id' => $_POST['comment']['postId']]);
    }

}
