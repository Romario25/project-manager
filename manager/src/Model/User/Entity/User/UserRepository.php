<?php


namespace App\Model\User\Entity\User;


interface UserRepository
{
    public function add(User $user): void ;

    public function hasByEmail(Email $email): bool;

    public function findByConfirmToken(string $token): ?User;

}