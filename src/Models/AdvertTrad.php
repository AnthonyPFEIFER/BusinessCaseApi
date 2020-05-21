<?php

namespace App\Models;

class AdvertTrad
{
    private $id;
    private $garage;
    private $model;
    private $brand;
    private $title;
    private $description;
    private $dateImmat;
    private $km;
    private $ref;
    private $price;
    private $fuel;

    public function getId()
    {
        return $this->id;
    }


    public function getBrand()
    {
        return $this->brand;
    }
    public function setBrand($brand)
    {
        $this->brand = $brand;

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
    public function getGarage()
    {
        return $this->garage;
    }

    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    public function getFuel()
    {
        return $this->fuel;
    }

    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDateImmat()
    {
        return $this->dateImmat;
    }

    public function setDateImmat($dateImmat)
    {
        $this->dateImmat = $dateImmat;

        return $this;
    }

    public function getKm()
    {
        return $this->km;
    }

    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
