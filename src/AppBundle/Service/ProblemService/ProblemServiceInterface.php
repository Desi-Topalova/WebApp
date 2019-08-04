<?php


namespace AppBundle\Service\ProblemService;


use AppBundle\Entity\Problem;


interface ProblemServiceInterface
{
public function createProblem(Problem $problem):bool;
public function editProblem(Problem $problem):bool;
public function deleteProblem(Problem $problem):bool;
public function findAllProblems(): ?Problem;
public function findOneProblemById(int $id): ?Problem;

}