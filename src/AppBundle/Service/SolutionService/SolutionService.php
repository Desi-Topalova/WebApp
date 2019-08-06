<?php


namespace AppBundle\Service\SolutionService;


use AppBundle\Entity\Problem;
use AppBundle\Entity\Solution;
use AppBundle\Entity\User;
use AppBundle\Repository\SolutionRepository;
use AppBundle\Service\ProblemService\ProblemServiceInterface;
use AppBundle\Service\UserService\UserServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;

class SolutionService implements SolutionServiceInterface
{
    private $userService;
    private $problemService;
    private $solutionRepository;
    public function __construct(UserServiceInterface $userService, ProblemServiceInterface $problemService,SolutionRepository $solutionRepository)
    {
        $this->userService=$userService;
        $this->problemService=$problemService;
        $this->solutionRepository=$solutionRepository;
    }

    public function addSolution(Solution $solution): bool
    {
        /** @var Problem $solution */
        $solution->setCreator($this->userService->currentUser())
                 ->setProblem($solution)
                  ->setDateAdded();


    }

    /**
     * @param User $user
     * @return ArrayCollection|object
     */
    public function findSolutionsByUser(User $user): ArrayCollection
    {
        return $this->solutionRepository->findOneBy(['solution'=>$user]);
    }

    /**
     * @param Problem $problem
     * @return ArrayCollection|object|array
     */
    public function findSolutionsByProblem(Problem $problem): ArrayCollection
    {
        return $this->solutionRepository->findBy(['solution'=>$problem]);
    }

    /**
     * @param Solution $solution
     * @return bool
     */
    public function deleteSolution(Solution $solution): bool
    {
        return $this->solutionRepository->lostSolution($solution);
    }
}