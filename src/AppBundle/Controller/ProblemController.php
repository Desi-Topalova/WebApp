<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Problem;
use AppBundle\Form\ProblemType;
use AppBundle\Service\ProblemService\ProblemServiceInterface;
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
    public function __construct(ProblemServiceInterface $problemService)
    {
        $this->problemService=$problemService;
    }

    /**
     * @Route("/create",methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return $this->render('', array('form' => $this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("/create",methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function createProcess(Request $request){
        $problem=new Problem();
        $form=$this->createForm(ProblemType::class,$problem);
        $form->handleRequest($request);
        $this->problemService->createProblem($problem);
        return $this->redirectToRoute('index');

    }

    /**
     * @Route("/edit", methods={"POST"})
     * @param int $id
     * @return Response
     */
    public function edit(int $id){
        $problem=$this->getDoctrine()->getRepository(Problem::class)->find($id);
        if (null===$problem){
            return $this->redirectToRoute("index");
        }
        return $this->render('', array('problem'=>$problem,
            'form'=>$this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("/edit", methods={"GET"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editProcess(Request $request, int $id){
        $problem=$this->problemService->findOneProblemById($id);
        $form=$this->createForm(ProblemType::class,$problem);
        $form->handleRequest($request);
        $this->problemService->editProblem($problem);
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/delete",methods={"GET"})
     *
     * @param int $id
     * @return Response
     */
    public function delete(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("index");
        }
        return $this->render('', array('problem'=>$problem,
            'form'=>$this->createForm(ProblemType::class)->createView()));
    }

    /**
     * @Route("/delete",methods={"POST"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteProcess(Request $request,int $id){
        $problem=$this->problemService->findOneProblemById($id);
        $form=$this->createForm(ProblemType::class,$problem);
        $form->handleRequest($request);
        $this->problemService->deleteProblem($problem);

        return $this->redirectToRoute('index');
    }

    /**
     * @param int $id
     * @return Response
     */
    public function view(int $id){
        $problem=$this->problemService->findOneProblemById($id);
        if (null===$problem){
            return $this->redirectToRoute("index");
        }
        $problem ->setViewCount($problem->getViewCount()+1);
    }
    public function getAllProblemsByUser(){
       $problem= $this->problemService->findAllProblems();
        return $this->render('',array('problems'=>$problem));
    }
}
