<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Problem;
use AppBundle\Entity\User;
use AppBundle\Form\ProblemType;
use AppBundle\Service\ProblemService\ProblemServiceInterface;
use AppBundle\Service\UserService\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProblemController extends Controller
{
    /**
     * @var ProblemServiceInterface
     */
    private $problemService;
    /**
     * @var UserServiceInterface
     */
    private $userService;
    public function __construct(ProblemServiceInterface $problemService, UserServiceInterface $userService)
    {
        $this->problemService=$problemService;
        $this->userService=$userService;
    }
    /**
     * @Route("/create",name="create",methods={"GET"})
     * @param Request $request
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function create(Request $request)
    {
        return $this->render('user/create.html.twig', array('form' => $this->createForm(ProblemType::class)->createView()));
    }
    /**
     * @Route("/create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function createProcess(Request $request){
        $problem=new Problem();
        $form=$this->createForm(ProblemType::class,$problem);
        $form->handleRequest($request);
        $this->problemService->createProblem($problem);
        return $this->redirectToRoute('index');

    }

    /**
     * @Route("/edit",name="edit", methods={"GET"})
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function edit(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("index");
        }
        return $this->render('user/edit.html.twig', array('problem'=>$problem,
            'form'=>$this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("/edit", methods={"POST"})
     * @param Request $request
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editProcess(Request $request, int $id){
        $problem=$this->problemService->findOneProblemById($id);
        $form=$this->createForm(ProblemType::class,$problem);
        $form->handleRequest($request);
        $this->problemService->editProblem($problem);
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/delete",name="delete",methods={"GET"})
     *@Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param int $id
     * @return Response
     */
    public function delete(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("index");
        }
        return $this->render('user/delete.html.twig', array('problem'=>$problem,
            'form'=>$this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("/delete",methods={"POST"})
     * @param Request $request
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function deleteProcess(Request $request,int $id){
        $problem=$this->problemService->findOneProblemById($id);
        $form=$this->createForm(ProblemType::class,$problem);
        $form->handleRequest($request);
        $this->problemService->deleteProblem($problem);

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/article/{id}",name="view")
     * @param int $id
     * @return Response
     */
    public function view(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("index");
        }
        $problem ->setViewCount($problem->getViewCount()+1);
        return $this->render("user/view.html.twig", array('problem'=>$problem));
    }

    /**
     * @Route("/problems/my_problems",name="my_problems")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function getAllProblemsByUser(){
       $problem= $this->problemService->findAllProblems();
        return $this->render('user/myProblems.html.twig',array('problems'=>$problem));
    }

    /**
     * @param Problem $problem
     * @return bool
     */
    private function isCreatorOrAdmin(Problem $problem){
        /**
         * @var User $currentUser
         */
        $currentUser=$this->getUser();
        /** @var Problem $problem */
        if (!$currentUser->isCreator($problem)&& !$currentUser->isAdmin()){
            return false;
        }
        return true;
    }
}
