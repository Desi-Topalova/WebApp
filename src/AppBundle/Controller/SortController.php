<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProblemType;
use AppBundle\Repository\PostRepository;
use AppBundle\Repository\ProblemRepository;
use AppBundle\Service\ProblemService\ProblemServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin", name="admin")
 * Class SortController
 * @package AppBundle\Controller
 */
class SortController extends Controller
{
    private $problemRepository;
    private $problemService;
    private $postRepository;
    public function __construct(ProblemRepository $problemRepository, ProblemServiceInterface $problemService,PostRepository $postRepository)
    {
        $this->problemRepository=$problemRepository;
        $this->problemService=$problemService;
        $this->postRepository=$postRepository;
    }



    /**
     * @param Request $request
     * @return Response
     */
    public function sortProblem(Request $request){
        $problem=$this->problemRepository->findBy([],['viewCount'=>'DESC','dateAdded'=>'DESC']);
        return $this->render('',array('problem'=>$problem));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function sortPost(Request $request){
        $post=$this->postRepository
            ->findBy([],['viewCount'=>'DESC','dateAdded'=>'DESC']);
        return $this->render('post/viewPost.html.twig',array('post'=>$post));
    }

}
