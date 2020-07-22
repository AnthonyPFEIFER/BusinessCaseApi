<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asserts;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 */
class Advert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Asserts\NotNull
     * @Groups({"adverts"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Garage", inversedBy="adverts")
     * @Groups({"adverts"})
     */
    private $garage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fuel", inversedBy="adverts")
     * @Groups({"adverts"})
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=5, max=25 )
     * @Groups({"adverts"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asserts\Length(min=5, max=255 )
     * @Groups({"adverts"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Asserts\Length(min=4, max=4 )
     * @Groups({"adverts"})
     * @Asserts\Positive
     * 
     */
    private $dateImmat;

    /**
     * @ORM\Column(type="integer")
     * @Asserts\Length(min=1, max=6 )
     * @Groups({"adverts"})
     */
    private $km;

    /**
     * @ORM\Column(type="float")
     * @Asserts\Length(min=2, max=6 )
     * @Groups({"adverts"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Model", inversedBy="adverts")
     * @Groups({"adverts"})
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="advert")
     */
    private $pictures;

    /**
     * @ORM\Column(type="string")
     * @Groups({"adverts"})
     */
    private $ref;

    public function __construct()
    {
        /*         $this->pictures = new ArrayCollection(); */
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getFuel(): ?Fuel
    {
        return $this->fuel;
    }

    public function setFuel(?Fuel $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateImmat()
    {
        return $this->dateImmat;
    }

    public function setDateImmat($dateImmat): self
    {
        $this->dateImmat = $dateImmat;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }
    public function getRef()
    {
        return $this->ref;
    }
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }
}
