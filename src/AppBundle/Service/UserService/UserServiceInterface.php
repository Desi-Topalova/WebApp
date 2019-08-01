<?php


namespace AppBundle\Service\UserService;


use AppBundle\Entity\User;

interface UserServiceInterface
{
public function findOneByUsername(string $username):?User;
public function findOneById(int $id):?User;
public function findOne(User $user):?User;
public function currentUser():?User;
public function save(User $user):bool;
}