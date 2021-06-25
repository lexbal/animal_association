<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DonationRepository::class)
 */
class Donation
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donations")
     */
    private $donator;

    /**
     * @var float
     *
     * @Assert\NotBlank
     * @Assert\GreaterThan(
     *     value = 0
     * )
     * @ORM\Column(type="float")
     */
    private $amount;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getDonator(): ?User
    {
        return $this->donator;
    }

    /**
     * @param User|null $donator
     * @return $this
     */
    public function setDonator(?User $donator): self
    {
        $this->donator = $donator;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
