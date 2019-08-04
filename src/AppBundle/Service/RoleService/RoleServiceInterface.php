<?php


namespace AppBundle\Service\RoleService;


interface RoleServiceInterface
{
    public function findOneBy(string $criteria);
}