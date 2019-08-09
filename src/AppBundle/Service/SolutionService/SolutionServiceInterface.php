<?php


namespace AppBundle\Service\SolutionService;


use AppBundle\Entity\Problem;
use AppBundle\Entity\Solution;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

interface SolutionServiceInterface
{
public function addSolution(Solution $solution, int $id):bool;
public function findSolutionsByUser(User $user): ArrayCollection;
public function findSolutionsByProblem(int $id):ArrayCollection;
public function deleteSolution(Solution $solution):bool;
}