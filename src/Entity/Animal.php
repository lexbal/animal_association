<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
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
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $birth_date;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $height;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breed;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $adopted = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $adopted_at;

    /**
     * @ORM\ManyToOne(targetEntity=AnimalType::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="animals")
     */
    private $owner;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Animal
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birth_date;
    }

    /**
     * @param DateTimeInterface $birth_date
     * @return $this
     */
    public function setBirthDate(DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @param float $height
     * @return $this
     */
    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return $this
     */
    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBreed(): ?string
    {
        return $this->breed;
    }

    /**
     * @param string|null $breed
     * @return $this
     */
    public function setBreed(?string $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAdopted(): ?bool
    {
        return $this->adopted;
    }

    /**
     * @param bool $adopted
     * @return $this
     */
    public function setAdopted(bool $adopted): self
    {
        $this->adopted = $adopted;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getAdoptedAt(): ?DateTimeInterface
    {
        return $this->adopted_at;
    }

    /**
     * @param DateTimeInterface|null $adopted_at
     * @return $this
     */
    public function setAdoptedAt(?DateTimeInterface $adopted_at): self
    {
        $this->adopted_at = $adopted_at;

        return $this;
    }

    /**
     * @return AnimalType|null
     */
    public function getType(): ?AnimalType
    {
        return $this->type;
    }

    /**
     * @param AnimalType|null $type
     * @return $this
     */
    public function setType(?AnimalType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     * @return $this
     */
    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
