<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Service\UserService\UserServiceInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService=$userService;
    }
    /**
     * @Route("/login",name="login")
     * @return Response
     */
   public function login(){
       return $this->render('home/login.html.twig');
   }

    /**
     * @Route("/register", name="register",methods={"GET"})
     * @param Request $request
     * @return Response
     */
   public function register(Request $request){
      return $this->render('home/register.html.twig', array('form'=>$this->createForm(UserType::class)->createView()));
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
       //if (null!==$this->userService->findOneByUsername($form['username'])->getData()->getUsername(){
          // $this->addFlash('error','Потрбителското име е заето.');
           //return $this->render('home/register.html.twig', ['user'=>$user,'form'=>$this->createForm(UserType::class)->createView()]);
      // }
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
        return $this->render('home/profile.html.twig', array('profile'=>$this->userService->currentUser()));
    }
}
