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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Asserts\Length(min=4, max=15 )
     * @Asserts\Unique
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=7, max=15 )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user"})
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
        $roles = $this->roles;

        $roles[] = 'ROLE_PRO';
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);

        /*         $this->roles = ['ROLE_ADMIN', 'ROLE_PRO'];
        return $this->roles; */
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
