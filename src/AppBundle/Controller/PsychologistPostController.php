<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PsychologistPost;
use AppBundle\Form\PsychologistPostType;
use AppBundle\Service\PsychologistPostService\PsychologistPostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PsychologistPostController extends Controller
{
   private $psychologistPost;
   public function __construct(PsychologistPostServiceInterface $psychologistPost)
   {
       $this->psychologistPost=$psychologistPost;
   }
    /**
     * @Route("/",methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createPost(Request $request)
    {
        return $this->render('', array('form' => $this->createForm(PsychologistPostType::class)->createView()));
    }
    /**
     * @Route("/create",methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function createPostProcess(Request $request){
        $psychologistPost=new PsychologistPost();
        $form=$this->createForm(PsychologistPostType::class,$psychologistPost);
        $form->handleRequest($request);
        $this->psychologistPost->createPost($psychologistPost);
        return $this->redirectToRoute('index');

    }
    /**
     * @Route("/edit", methods={"POST"})
     * @param int $id
     * @return Response
     */
    public function editPost(int $id){
        $psychologistPost=$this;
        if (null===$psychologistPost){
            return $this->redirectToRoute("index");
        }
        return $this->render('', array('psychologistPost'=>$psychologistPost,
            'form'=>$this->createForm(PsychologistPostType::class)->createView()));
    }
    /**
     * @Route("/edit", methods={"GET"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editPostProcess(Request $request, int $id){
        $psychologistPost=$this->psychologistPost->findPostByID($id);
        $form=$this->createForm(PsychologistPostType::class,$psychologistPost);
        $form->handleRequest($request);
        $this->psychologistPost->editPost($psychologistPost);
        return $this->redirectToRoute('index');
    }
}
