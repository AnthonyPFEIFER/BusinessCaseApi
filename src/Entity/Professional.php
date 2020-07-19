<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asserts;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionalRepository")
 */
class Professional implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Asserts\NotNull
     * @Groups("pros")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups("pros")
     * @Asserts\Length(min=2, max=20 )
     * @Asserts\Unique
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=7, max=25 )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $apiKey;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=4, max=25 )
     * @Groups("pros")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=4, max=25 )
     * @Groups("pros")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pros")
     * @Asserts\Length(min=4, max=25 )
     * @Asserts\Email
     * @Asserts\Unique
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pros")
     * @Asserts\Length(min=10, max=10 )
     * @Asserts\Unique
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pros")
     * @Asserts\Length(min=14, max=14 )
     * @Asserts\Unique
     */
    private $siret;

    /**
     * @ORM\Column(type="json", length=255)
     * @Groups("pros")
     * @Asserts\Length(min=14, max=14 )
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Garage", mappedBy="professional")
     */
    private $garages;

    public function __construct()
    {
        $this->garages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_PRO';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * @return Collection|Garage[]
     */
    public function getGarages(): Collection
    {
        return $this->garages;
    }

    public function addGarage(Garage $garage): self
    {
        if (!$this->garages->contains($garage)) {
            $this->garages[] = $garage;
            $garage->setProfessional($this);
        }

        return $this;
    }

    public function removeGarage(Garage $garage): self
    {
        if ($this->garages->contains($garage)) {
            $this->garages->removeElement($garage);
            // set the owning side to null (unless already changed)
            if ($garage->getProfessional() === $this) {
                $garage->setProfessional(null);
            }
        }

        return $this;
    }
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
    }
}
