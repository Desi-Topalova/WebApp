<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PsychologistPost;
use AppBundle\Form\PsychologistPostType;
use AppBundle\Service\PsychologistPostService\PsychologistPostServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Route("/create_post",name="create_post",methods={"GET"})
     * @param Request $request
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function createPost(Request $request)
    {
        return $this->render('psychologist/create_post.html.twig', array('form' => $this->createForm(PsychologistPostType::class)->createView()));
    }
    /**
     * @Route("/create_post",methods={"POST"})
     * @param Request $request
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function createPostProcess(Request $request){
        $psychologistPost=new PsychologistPost();
        $form=$this->createForm(PsychologistPostType::class,$psychologistPost);
        $form->handleRequest($request);
        $this->psychologistPost->createPost($psychologistPost);
        return $this->redirectToRoute('index');

    }
    /**
     * @Route("/edit_post",name="edit_post", methods={"GET"})
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editPost(int $id){
        $psychologistPost=$this;
        if (null===$psychologistPost){
            return $this->redirectToRoute("index");
        }
        return $this->render('psychologist/edit_post.html.twig', array('psychologistPost'=>$psychologistPost,
            'form'=>$this->createForm(PsychologistPostType::class)->createView()));
    }
    /**
     * @Route("/edit", methods={"POST"})
     * @param Request $request
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editPostProcess(Request $request, int $id){
        $psychologistPost=$this->psychologistPost->findPostByID($id);
        $form=$this->createForm(PsychologistPostType::class,$psychologistPost);
        $form->handleRequest($request);
        $this->psychologistPost->editPost($psychologistPost);
        return $this->redirectToRoute('index');
    }
    /**
     * @Route("/post/{id}",name="view")
     * @param int $id
     * @return Response
     */
    public function view(int $id){
        $post=$this->psychologistPost->findPostByID($id);
        if (null===$post){
            return $this->redirectToRoute("index");
        }
       // $post ->setViewCount($post->getViewCount()+1);
        return $this->render("psychologist/viewPost.html.twig", array('post'=>$post));
    }

}
