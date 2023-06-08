<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min: 10, max: 180)]
    private ?string $email = null;

    #[ORM\Column(type:'json')]
    #[Assert\NotNull()]
    private array $roles = [];

    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 8, max: 100)]
    private string $password = 'password';

    #[ORM\Column(length: 255, nullable:true)]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isValid = null;

    #[ORM\OneToMany(mappedBy: 'recruteur', targetEntity: Notice::class, orphanRemoval: true)]
    private Collection $notice;

    public function __construct()
    {
        $this->notice = new ArrayCollection();
    }

    /**
     * GETTERS and SETTERS
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * @return Collection<int, Notice>
     */
    public function getNotice(): Collection
    {
        return $this->notice;
    }

    public function addNotice(Notice $notice): self
    {
        if (!$this->notice->contains($notice)) {
            $this->notice->add($notice);
            $notice->setRecruteur($this);
        }

        return $this;
    }

    public function removeNotice(Notice $notice): self
    {
        if ($this->notice->removeElement($notice)) {
            // set the owning side to null (unless already changed)
            if ($notice->getRecruteur() === $this) {
                $notice->setRecruteur(null);
            }
        }

        return $this;
    }

}
