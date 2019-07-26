<?php


namespace App\Model\User\Entity\User;


class User
{
    /** @var string */
    private $id;

    /** @var \DateTimeImmutable */
    private $date;

    /** @var string  */
    private $email;

    /** @var string  */
    private $passwordHash;

    public function __construct(string $id, \DateTimeImmutable $date, string $email, string $hash)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $hash;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPasswordHash() : string
    {
        return $this->passwordHash;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}