<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Problem;
use AppBundle\Entity\User;
use AppBundle\Form\ProblemType;
use AppBundle\Repository\ProblemRepository;
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

    /**
     * @var ProblemRepository
     */
    private $problemRepository;
    public function __construct(ProblemServiceInterface $problemService,
                                UserServiceInterface $userService, ProblemRepository $problemRepository)
    {
        $this->problemService=$problemService;
        $this->userService=$userService;
        $this->problemRepository=$problemRepository;
    }

    /**
     * @Route("/create",name="create",methods={"GET"})
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function create()
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
        return $this->redirectToRoute('view');

    }

    /**
     * @Route("/edit/{id}",name="edit", methods={"GET"})
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function edit(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("profile");
        }
        return $this->render('user/edit.html.twig', array('problem'=>$problem,'id'=>$id,
            'form'=>$this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("/edit/{id}", methods={"POST"})
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
        return $this->redirectToRoute('myProblems');
    }


    /**
     * @Route("/problem/view",name="view")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function getAllProblemsByUser(){
       $problem= $this->problemService->findAllProblems();
        return $this->render('',array('problem'=>$problem));
    }

    /**
     * @Route("/myProblems", name="myProblems")
     * @return Response
     */
    public function myProblems(){
        $problems = $this->problemRepository->findBy(['creator' => $this->getUser()]);
        return $this->render("user/myProblems.html.twig",
            ['problems' => $problems]);
    }
    /**
     * @Route("admin/delete/{id}",name="delete",methods={"GET"})
     *@Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param int $id
     * @return Response
     */
    public function delete(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("");
        }
        return $this->render('user/delete.html.twig', array('problem'=>$problem,
            'form'=>$this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("admin/delete/{id}",methods={"POST"})
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

        return $this->redirectToRoute('myProblems');
    }




}
