<?php


namespace AppBundle\Service\EncryptionService;


interface EncryptionServiceInterface
{
public function hash(string $password);
public function verify(string $password, string $hash);
}