<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Fuel;
use App\Entity\Garage;
use App\Entity\Model;
use App\Models\AdvertTrad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class AdvertController extends AbstractController
{


    /**
     * @Route("/adverts", name="adverts", methods={"GET"})
     */
    public function getAdverts(SerializerInterface $serializer)
    {
        $adverts = $this->getDoctrine()->getRepository(Advert::class)->getAllAdverts();
        $adverts = $serializer->serialize($adverts, 'json');

        return new JsonResponse($adverts, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/admin/advert/{id}", name="advert", methods={"GET"})
     */
    public function getAdvert(SerializerInterface $serializer, $id)
    {
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $advertRepository->findOneBy(['id' => $id]);
        $advert = $serializer->serialize($advert, 'json', ["groups" => "adverts"]);

        return new JsonResponse($advert, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/pro/detail-advert/{id}", name="advert", methods={"GET"})
     */
    public function getAdvertById(SerializerInterface $serializer, $id)
    {
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $advertRepository->findOneBy(['id' => $id]);
        $advert = $serializer->serialize($advert, 'json', ["groups" => "adverts"]);

        return new JsonResponse($advert, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/pro/addAdvert/{id}", name="addAdvert", methods={"POST"})
     */
    public function addAdvert(Request $request, SerializerInterface $serializer, $id)
    {
        $advertAdd = $request->getContent();
        $advertTrad = $serializer->deserialize($advertAdd, AdvertTrad::class, 'json');

        $modelRepository = $this->getDoctrine()->getRepository(Model::class);
        $modele = $modelRepository->findOneBy(['name' => $advertTrad->getModel()]);

        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garage = $garageRepository->findOneBy(['name' => $advertTrad->getGarage()]);

        $fuelRepository = $this->getDoctrine()->getRepository(Fuel::class);
        $fuel = $fuelRepository->findOneBy(['type' => $advertTrad->getFuel()]);

        $advert = $serializer->deserialize($advertAdd, Advert::class, 'json');
        $advert->setGarage($garage);
        $advert->setModel($modele);
        $advert->setFuel($fuel);
        $advert->setRef(uniqid());

        $this->getDoctrine()->getManager()->persist($advert);
        $this->getDoctrine()->getManager()->flush();

        $advertToAdd = $serializer->serialize($advert, 'json', ["groups" => "adverts"]);
        return new JsonResponse($advertToAdd, 201, [], true);
    }
    /**
     * @Route("/pro/advert-add/{id}", name="add-advert", methods={"POST"}) 
     */
    public function advertAdd(Request $request, SerializerInterface $serializer, $id)
    {
        $advertAdd = $request->getContent();
        $advertTrad = $serializer->deserialize($advertAdd, AdvertTrad::class, 'json');

        $modelRepository = $this->getDoctrine()->getRepository(Model::class);
        $modele = $modelRepository->findOneBy(['name' => $advertTrad->getModel()]);

        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garage = $garageRepository->findOneBy(['name' => $advertTrad->getGarage()]);

        $fuelRepository = $this->getDoctrine()->getRepository(Fuel::class);
        $fuel = $fuelRepository->findOneBy(['type' => $advertTrad->getFuel()]);

        $advert = $serializer->deserialize($advertAdd, Advert::class, 'json');
        $advert->setGarage($garage);
        $advert->setModel($modele);
        $advert->setFuel($fuel);
        $advert->setRef(uniqid());

        $this->getDoctrine()->getManager()->persist($advert);
        $this->getDoctrine()->getManager()->flush();

        $advertToAdd = $serializer->serialize($advert, 'json', ["groups" => "adverts"]);
        return new JsonResponse($advertToAdd, 201, [], true);
    }

    /**
     * @Route("/pro/advert-edit/{id}", name="edit_advert", methods={"PUT"})
     */
    public function modify(SerializerInterface $serializer, Request $request, $id)
    {
        $data = $request->getContent();
        $advertTrad = $serializer->deserialize($data, AdvertTrad::class, 'json');

        $modeleRepository = $this->getDoctrine()->getRepository(Model::class);
        $modele = $modeleRepository->findOneBy(['name' => $advertTrad->getModel()]);

        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garage = $garageRepository->findOneBy(['id' => $advertTrad->getGarage()]);

        $fuelRepository = $this->getDoctrine()->getRepository(Fuel::class);
        $fuel = $fuelRepository->findOneBy(['type' => $advertTrad->getFuel()]);

        $advert = $serializer->deserialize($data, Advert::class, 'json');
        $advert->setGarage($garage);
        $advert->setModel($modele);
        $advert->setFuel($fuel);

        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advertEdit = $advertRepository->findOneBy(['id' => $id]);
        if ($advert->getTitle() !== null && $advert->getTitle() !== $advertEdit->getTitle()) {
            $advertEdit->setTitle($advert->getTitle());
        }
        if ($advert->getDescription() !== null && $advert->getDescription() !== $advertEdit->getDescription()) {
            $advertEdit->setDescription($advert->getDescription());
        }
        if ($advert->getDateImmat() !== null && $advert->getDateImmat() !== $advertEdit->getDateImmat()) {
            $advertEdit->setDateImmat($advert->getDateImmat());
        }
        if ($advert->getKm() !== null && $advert->getKm() !== $advertEdit->getKm()) {
            $advertEdit->setKm($advert->getKm());
        }
        if ($advert->getPrice() !== null && $advert->getPrice() !== $advertEdit->getPrice()) {
            $advertEdit->setPrice($advert->getPrice());
        }
        if ($advert->getFuel() !== null && $advert->getFuel() !== $advertEdit->getFuel()) {
            $advertEdit->setFuel($advert->getFuel());
        }
        if ($advert->getModel() !== null && $advert->getModel() !== $advertEdit->getModel()) {
            $advertEdit->setModel($advert->getModel());
        }

        $this->getDoctrine()->getManager()->persist($advertEdit);
        $this->getDoctrine()->getManager()->flush();

        $advertEdit = $serializer->serialize($advertEdit, 'json', ["groups" => "adverts"]);

        return new JsonResponse($advertEdit, 200, [], true);
    }
    /**
     * @Route("/pro/delete-advert/{id}", name="delete-advert", methods={"DELETE"})
     */
    public function delete(SerializerInterface $serializer, Request $request, $id)
    {
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advertToDelete = $advertRepository->findOneBy(['id' => $id]);

        $this->getDoctrine()->getManager()->remove($advertToDelete);
        $this->getDoctrine()->getManager()->flush();

        $advert = $serializer->serialize($advertToDelete, 'json', ["groups" => "adverts"]);
        return new JsonResponse($advert, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/pro/adverts-number", name="number-adverts", methods={"GET"})
     */
    public function getAdvertsNumber(SerializerInterface $serializer)
    {
        $adverts = $this->getDoctrine()->getRepository(Advert::class)->getNumberOfAdverts();
        $adverts = $serializer->serialize($adverts, 'json');

        return new JsonResponse($adverts, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/admin/advertsByGarage/{id}", name="advertsByGarage", methods={"GET"})
     */
    public function advertByGarage(SerializerInterface $serializer, $id)
    {
        $modeleRepository = $this->getDoctrine()->getRepository(Advert::class);
        $modele = $modeleRepository->getAdvertByGarage($id);
        $modele = $serializer->serialize($modele, 'json');

        return new JsonResponse($modele, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/admin/advertsByPro/{id}", name="advertsByPro", methods={"GET"})
     */
    public function advertByPro(SerializerInterface $serializer, $id)
    {
        $modeleRepository = $this->getDoctrine()->getRepository(Advert::class);
        $modele = $modeleRepository->getAdvertByPro($id);
        $modele = $serializer->serialize($modele, 'json');

        return new JsonResponse($modele, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/advert/filter", name="filterAdvert", methods={"GET"})
     */
    // Return advert with filter
    public function filterAdvert(SerializerInterface $serializer, $fuel, $dateImmat, $km, $price, $model, $brand)
    {
        $adverts = $this->getDoctrine()->getRepository(Advert::class)->getAdvertsBySearch($fuel, $dateImmat, $km, $price, $model, $brand);
        $adverts = $serializer->serialize($adverts, 'json');

        return new JsonResponse($adverts, Response::HTTP_OK, [], true);
    }

    /* Fonctionnent:
            /advert-delete/
            /adverts-number
            /advert-add
            /advert-edit/
    */
}
