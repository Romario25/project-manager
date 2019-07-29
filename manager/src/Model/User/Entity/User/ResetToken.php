<?php

namespace App\Model\User\Entity\User;


use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ResetToken
 * @ORM\Embeddable()
 */
class ResetToken
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $expires;

    public function __construct(string $token, \DateTimeImmutable $expires)
    {
        Assert::notEmpty($token);

        $this->token = $token;
        $this->expires = $expires;
    }

    public function isExpiredTo(\DateTimeImmutable $date): bool
    {
        return $this->expires <= $date;
    }


    public function getToken() : string
    {
        return $this->token;
    }

    public function isEmpty()
    {
        return empty($this->token);
    }

}