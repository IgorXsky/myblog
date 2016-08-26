<?php
namespace BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class UserController extends Controller
{

    public function loginAction(Request $request)
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $userName     = $request->request->get('login');
            $userPassword = $request->request->get('password');
            $user = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository("BlogBundle:User")
                ->findOneBy([
                    'userName' => $userName,
                    'userPassword' => $userPassword
                ]);

            if (!is_null($user)) {
                $session = new Session();
                $session->set("user", $user);
            }
        }
        return $this->render('BlogBundle:User:login.html.twig', array());
    }
    public function logoutAction()
    {
        $session = new Session();
        $session->clear();
        return $this->render('BlogBundle:User:login.html.twig', array(

        ));
    }
}