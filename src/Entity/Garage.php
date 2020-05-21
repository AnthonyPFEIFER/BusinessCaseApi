<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asserts;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GarageRepository")
 */
class Garage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"adverts"})
     * @Groups({"garage"})
     * @Asserts\NotNull
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professional", inversedBy="garages")
     */
    private $professional;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=4, max=30 )
     * @Groups({"garage"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=10, max=10 )
     * @Groups({"garage"})
     * @Asserts\Unique
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=5, max=40 )
     * @Groups({"garage"})
     * @Asserts\Unique
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=2, max=25 )
     * @Groups({"garage"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=5, max=5 )
     * @Groups({"garage"})
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=2, max=30 )
     * @Groups({"garage"})
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="garage")
     */
    private $adverts;

    public function __construct()
    {
        $this->adverts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(?Professional $professional): self
    {
        $this->professional = $professional;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->setGarage($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getGarage() === $this) {
                $advert->setGarage(null);
            }
        }

        return $this;
    }
}
