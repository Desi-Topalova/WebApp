<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Service\UserService\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService=$userService;
    }
    /**
     * @Route("/login",name="login")
     * @return Response
     */
   public function login(){
       return $this->render('user/login.html.twig');
   }

    /**
     * @Route("/register", name="register",methods={"GET"})
     * @param Request $request
     * @return Response
     */
   public function register(Request $request){
      return $this->render('user/register.html.twig', array('form'=>$this->createForm(UserType::class)->createView()));
   }

    /**
     * @Route("/register",methods={"POST"})
     * @param Request $request
     * @return Response
     */
   public function registerProcess(Request $request){
       $user=new User();
       $form=$this->createForm(UserType::class,$user);
       $form->handleRequest($request);
       $this->userService->save($user);
       return $this->redirectToRoute('login');
   }

    /**
     * @Route("/logout", name="logout")
     * @throws Exception
     */
    public function logout(){
        throw new Exception("Logout failed.");

    }

    /**
     * @Route("/profile",name="profile")
     * @return Response
     */
    public function profile(){
        return $this->render('user/profile.html.twig', array('user'=>$this->userService->currentUser()));
    }
}
