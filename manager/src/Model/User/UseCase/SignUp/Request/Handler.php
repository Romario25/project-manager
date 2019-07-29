<?php


namespace App\Model\User\UseCase\SignUp\Request;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\ConfirmTokenizer;
use App\Model\User\Service\ConfirmTokenSender;
use App\Model\User\Service\PasswordHasher;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class Handler
{

    private $userRepository;

    private $passwordHasher;

    private $flusher;

    private $confirmTokenizer;

    private $sender;

    public function __construct(
        UserRepository $userRepository,
        PasswordHasher $passwordHasher,
        ConfirmTokenizer $confirmTokenizer,
        ConfirmTokenSender $confirmTokenSender,
        Flusher $flusher
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->flusher = $flusher;
        $this->confirmTokenizer = $confirmTokenizer;
        $this->sender = $confirmTokenSender;
    }

    public function handle(Command $command): void
    {

        $email = new Email($command->email);

        $token = $this->confirmTokenizer->generate();

        if ($this->userRepository->hasByEmail($email)) {
            throw new \DomainException('User already exists');
        }

        $user = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            $email,
            $this->passwordHasher->hash($command->password),
            $token
        );

        $this->userRepository->add($user);

        $this->sender->send($email, $token);

        $this->flusher->flush();
    }

}