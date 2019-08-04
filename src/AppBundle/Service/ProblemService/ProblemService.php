<?php


namespace AppBundle\Service\ProblemService;


use AppBundle\Entity\Problem;
use AppBundle\Repository\ProblemRepository;
use AppBundle\Service\UserService\UserServiceInterface;

class ProblemService implements ProblemServiceInterface
{
    /**
     * @var ProblemRepository
     */
private $problemRepository;

private $userService;

public function __construct(ProblemRepository $problemRepository, UserServiceInterface $userService)
{
    $this->problemRepository=$problemRepository;
    $this->userService=$userService;
}

    public function createProblem(Problem $problem):bool
    {
        $creator=$this->userService->currentUser();
        $problem->setCreator($creator);
        $problem->setViewCount(0);

        return $this->problemRepository->takeProblem($problem);

    }

    public function editProblem(Problem $problem):bool
    {
        return $this->problemRepository->changeProblem($problem);

    }

    public function deleteProblem(Problem $problem):bool
    {
        return $this->problemRepository->removeProblem($problem);
    }

    /**
     * @return Problem|null|array
     */
    public function findAllProblems(): ?Problem
    {
        return $this->problemRepository->findBy([],["dateAdded"=>'DESC']);
    }

    /**
     * @param int $id
     * @return Problem|null|object
     */
    public function findOneProblemById(int $id):?Problem
    {
        return $this->problemRepository->find($id);
    }

}