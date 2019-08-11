<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use AppBundle\Service\PostService\PostServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
   private $post;
   public function __construct(PostServiceInterface $post)
   {
       $this->post=$post;
   }
    /**
     * @Route("/create_post",name="create_post",methods={"GET"})
     * @param Request $request
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function createPost(Request $request)
    {
        return $this->render('post/create_post.html.twig', array('form' => $this->createForm(PostType::class)->createView()));
    }
    /**
     * @Route("/create_post",methods={"POST"})
     * @param Request $request
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function createPostProcess(Request $request){
        $post=new Post();
        $form=$this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        $this->post->createPost($post);
        return $this->redirectToRoute('viewPost');

    }
    /**
     * @Route("/edit_post",name="edit_post", methods={"GET"})
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editPost(int $id){
        $post=$this;
        if (null===$post){
            return $this->redirectToRoute("index");
        }
        return $this->render('post/edit_post.html.twig', array('post'=>$post,
            'form'=>$this->createForm(PostType::class)->createView()));
    }
    /**
     * @Route("/edit_post", methods={"POST"})
     * @param Request $request
     * @param int $id
     * @return Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editPostProcess(Request $request, int $id){
        $post=$this->post->findPostByID($id);
        $form=$this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        $this->post->editPost($post);
        return $this->redirectToRoute('viewPost');
    }

    /**
     * @Route("/post",name="viewPost")
     * @return Response
     */
    public function view(){
        $post=$this->post->findAllPosts();
        if (null===$post){
            return $this->redirectToRoute("profile");
        }
       // $post ->setdateAdded($post->getViewCount()+1);
        return $this->render("post/viewPost.html.twig", array('post'=>$post));
    }

}
