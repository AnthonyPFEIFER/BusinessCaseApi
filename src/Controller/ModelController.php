<?php

namespace App\Controller;


use App\Entity\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModelController extends AbstractController
{

    /**
     * @Route("/pro/modeles", name="modeles", methods={"GET"})
     */
    public function getAllModeles(SerializerInterface $serializer)
    {
        $modeleRepository = $this->getDoctrine()->getRepository(Model::class);
        $modeles = $modeleRepository->getModeles();
        $modeles = $serializer->serialize($modeles, 'json');

        return new JsonResponse($modeles, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/pro/modele/{id}", name="modele", methods={"GET"})
     */
    public function getModeleById(SerializerInterface $serializer, $id)
    {
        $modeleRepository = $this->getDoctrine()->getRepository(Model::class);
        $modele = $modeleRepository->getModeleById($id);
        $modele = $serializer->serialize($modele, 'json');

        return new JsonResponse($modele, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/pro/modeleByBrand/{id}", name="modeleByBrand", methods={"GET"})
     */
    public function modelByBrand(SerializerInterface $serializer, $id)
    {
        $modeleRepository = $this->getDoctrine()->getRepository(Model::class);
        $modele = $modeleRepository->getModeleByBrand($id);
        $modele = $serializer->serialize($modele, 'json');

        return new JsonResponse($modele, Response::HTTP_OK, [], true);
    }
    /* Fonctionnent:
        /modeles
        /modele/id
        /modeleByBrand/id
    */
}
