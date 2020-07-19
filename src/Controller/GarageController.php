<?php

namespace App\Controller;


use App\Entity\Garage;
use App\Entity\Professional;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GarageController extends AbstractController
{
    /**
     * @Route("/admin/garage/{id}", name="garage", methods={"GET"})
     */
    public function getGarage(SerializerInterface $serializer, $id)
    {
        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garage = $garageRepository->findOneBy(['id' => $id]);
        $groupGarage = 'garage';
        $garage = $serializer->serialize($garage, 'json',  ["groups" => $groupGarage]);

        return new JsonResponse($garage, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/admin/garages", name="garages", methods={"GET"})
     */
    public function getAllGarages(SerializerInterface $serializer)
    {
        $garages = $this->getDoctrine()->getRepository(Garage::class)->getAllGarages();
        $garages = $serializer->serialize($garages, 'json');

        return new JsonResponse($garages, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/admin/garageByPro/{id}", name="garageByPro", methods={"GET"})
     */
    public function garageByPro(SerializerInterface $serializer, $id)
    {
        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garage = $garageRepository->getGarageByPro($id);
        $garage = $serializer->serialize($garage, 'json');

        return new JsonResponse($garage, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/admin/garage-number", name="number-garage", methods={"GET"})
     */
    public function getNumberofGarages(SerializerInterface $serializer)
    {
        $garages = $this->getDoctrine()->getRepository(Garage::class)->getGarageNumber();
        $garages = $serializer->serialize($garages, 'json');

        return new JsonResponse($garages, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/admin/garage-add/{id}", name="garage-add", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, $id)
    {
        $garage = $serializer->deserialize($request->getContent(), Garage::class, 'json');
        $proRepository = $this->getDoctrine()->getRepository(Professional::class);
        $professional = $proRepository->findOneBy(['id' => $id]);
        $garage->setProfessional($professional);
        $this->getDoctrine()->getManager()->persist($garage);
        $this->getDoctrine()->getManager()->flush();

        $groupGarage = 'garage';
        $garage = $serializer->serialize($garage, 'json', ["groups" => $groupGarage]);

        return new JsonResponse($garage, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route("/admin/garage-edit/{id}", name="edit-garage", methods={"PUT"})
     */
    public function edit(Request $request, SerializerInterface $serializer, $id)
    {
        $data = $request->getContent();
        $garage = $serializer->deserialize($data, Garage::class, 'json');
        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $editGarage = $garageRepository->findOneBy(["id" => $id]);

        if ($garage->getName() !== null && $garage->getName() !== $editGarage->getName()) {
            $editGarage->setName($garage->getName());
        }
        if ($garage->getTel() !== null && $garage->getTel() !== $editGarage->getTel()) {
            $editGarage->setTel($garage->getTel());
        }
        if ($garage->getAddress() !== null && $garage->getAddress() !== $editGarage->getAddress()) {
            $editGarage->setAddress($garage->getAddress());
        }
        if ($garage->getCity() !== null && $garage->getCity() !== $editGarage->getCity()) {
            $editGarage->setCity($garage->getCity());
        }
        if ($garage->getPostCode() !== null && $garage->getPostCode() !== $editGarage->getPostCode()) {
            $editGarage->setPostCode($garage->getPostCode());
        }
        if ($garage->getCountry() !== null && $garage->getCountry() !== $editGarage->getCountry()) {
            $editGarage->setCountry($garage->getCountry());
        }

        $this->getDoctrine()->getManager()->persist($editGarage);
        $this->getDoctrine()->getManager()->flush();

        $groupGarage = 'garage';
        $garage = $serializer->serialize($editGarage, 'json', ["groups" => $groupGarage]);

        return new JsonResponse($garage, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/admin/garage-delete/{id}", name="garage-delete", methods={"DELETE"})
     */
    public function delete(SerializerInterface $serializer, Request $request, $id)
    {
        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garageDelete = $garageRepository->findOneBy(['id' => $id]);

        $this->getDoctrine()->getManager()->remove($garageDelete);
        $this->getDoctrine()->getManager()->flush();

        $groupGarage = 'garage';
        $garage = $serializer->serialize($garageDelete, 'json', ["groups" => $groupGarage]);

        return new JsonResponse($garage, Response::HTTP_CREATED, [], true);
    }
}
