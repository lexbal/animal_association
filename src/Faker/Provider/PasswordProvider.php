<?php

namespace App\Faker\Provider;

use App\Entity\User;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * Class PasswordProvider
 * @package App\Faker\Provider
 */
final class PasswordProvider extends BaseProvider
{
    /**
     * @var
     */
    private $password;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordEncoder;


    public function __construct(Generator $generator, UserPasswordHasherInterface $passwordEncoder)
    {
        parent::__construct($generator);

        $this->passwordEncoder = $passwordEncoder;
    }


    public function passwordGenerator(string $password)
    {
        $this->password = $this->passwordEncoder->hashPassword(
            new User(),
            $password
        );

        return $this->password;
    }
}