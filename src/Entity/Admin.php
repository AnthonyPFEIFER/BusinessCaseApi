<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asserts;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 * 
 */
class Admin implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Asserts\NotNull
     * @Groups({"admin"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Asserts\Length(min=4, max=15 )
     * @Asserts\Unique
     * @Groups({"admin"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=7, max=15 )
     * @Groups({"admin"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"admin"})
     */
    private $apiKey;

    private $roles = [];


    public function getId(): ?int
    {
        return $this->id;
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

    public function getRoles()
    {
        $this->roles = ["ROLE_ADMIN"];
        return $this->roles;
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
