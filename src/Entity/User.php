<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Range(
     *      min = 6,
     *      max = 4096,
     *      notInRangeMessage = "You must be between {{ min }}cm and {{ max }}cm tall to enter",
     * )
     */
    private $password;

    /**
     * @var Donation[]
     *
     * @ORM\OneToMany(targetEntity=Donation::class, mappedBy="donator")
     */
    private $donations;

    /**
     * @var Post[]
     *
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="author", orphanRemoval=true)
     */
    private $posts;

    /**
     * @var AnimalAccessory[]
     *
     * @ORM\ManyToMany(targetEntity=AnimalAccessory::class, inversedBy="users")
     */
    private $animalAccessories;

    /**
     * @ORM\OneToMany(targetEntity=Animal::class, mappedBy="owner")
     */
    private $animals;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->donations         = new ArrayCollection();
        $this->posts             = new ArrayCollection();
        $this->animalAccessories = new ArrayCollection();
        $this->animals           = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Donation[]
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    /**
     * @param Donation $donation
     * @return $this
     */
    public function addDonation(Donation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations[] = $donation;
            $donation->setDonator($this);
        }

        return $this;
    }

    /**
     * @param Donation $donation
     * @return $this
     */
    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getDonator() === $this) {
                $donation->setDonator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AnimalAccessory[]
     */
    public function getAnimalAccessories(): Collection
    {
        return $this->animalAccessories;
    }

    /**
     * @param AnimalAccessory $animalAccessory
     * @return $this
     */
    public function addAnimalAccessory(AnimalAccessory $animalAccessory): self
    {
        if (!$this->animalAccessories->contains($animalAccessory)) {
            $this->animalAccessories[] = $animalAccessory;
        }

        return $this;
    }

    /**
     * @param AnimalAccessory $animalAccessory
     * @return $this
     */
    public function removeAnimalAccessory(AnimalAccessory $animalAccessory): self
    {
        $this->animalAccessories->removeElement($animalAccessory);

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    /**
     * @param Animal $animal
     * @return $this
     */
    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setOwner($this);
        }

        return $this;
    }

    /**
     * @param Animal $animal
     * @return $this
     */
    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getOwner() === $this) {
                $animal->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCart(): int
    {
        return count($this->getAnimalAccessories()) + count($this->getAnimals());
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getEmail();
    }
}
