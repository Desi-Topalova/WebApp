<?php


namespace AppBundle\Service\PsychologistPostService;


use AppBundle\Entity\PsychologistPost;

interface PsychologistPostServiceInterface
{
    public function createPost(PsychologistPost $psychologistPost):bool;
    public function editPost(PsychologistPost $psychologistPost):bool;
    public function findPostByID(int $id):?PsychologistPost;
}