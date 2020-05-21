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
        $garage = $garageRepository->getGarageById($id);
        $garage = $serializer->serialize($garage, 'json');

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

        $garage = $serializer->serialize($garage, 'json', ["groups" => 'garage']);

        return new JsonResponse($garage, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route("/admin/garage-edit/{id}", name="edit-garage", methods={"PUT"})
     */
    public function modify(Request $request, SerializerInterface $serializer, $id)
    {
        $data = $request->getContent();
        $garage = $serializer->deserialize($data, Garage::class, 'json');
        $garageRepository = $this->getDoctrine()->getRepository(Garage::class);
        $garageModify = $garageRepository->findOneBy(["id" => $id]);

        if ($garage->getNom() !== null && $garage->getNom() !== $garageModify->getNom()) {
            $garageModify->setNom($garage->getNom());
        }
        if ($garage->getTel() !== null && $garage->getTel() !== $garageModify->getTel()) {
            $garageModify->setTel($garage->getTel());
        }
        if ($garage->getAdresse() !== null && $garage->getAdresse() !== $garageModify->getAdresse()) {
            $garageModify->setAdresse($garage->getAdresse());
        }
        if ($garage->getVille() !== null && $garage->getVille() !== $garageModify->getVille()) {
            $garageModify->setVille($garage->getVille());
        }

        $this->getDoctrine()->getManager()->persist($garageModify);
        $this->getDoctrine()->getManager()->flush();

        $garage = $serializer->serialize($garageModify, 'json', ["groups" => 'garage']);

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

        $garage = $serializer->serialize($garageDelete, 'json', ["groups" => 'garage']);

        return new JsonResponse($garage, Response::HTTP_CREATED, [], true);
    }
    /* fonctionnent:
        /garage/{id}
        /garages
        /garageByPro/
        /garage-number
    */
}
