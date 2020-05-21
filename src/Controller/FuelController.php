<?php

namespace App\Controller;


use App\Entity\Fuel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FuelController extends AbstractController
{
    /**
     * @Route("/pro/fuels", name="fuels", methods={"GET"})
     */
    public function getFuels(SerializerInterface $serializer)
    {
        $fuels = $this->getDoctrine()->getRepository(Fuel::class)->getAllFuels();
        $fuels = $serializer->serialize($fuels, 'json');

        return new JsonResponse($fuels, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/pro/fuel/{id}", name="fuel", methods={"GET"})
     */
    public function getFuelsById(SerializerInterface $serializer, $id)
    {
        $fuelRepository = $this->getDoctrine()->getRepository(Fuel::class);
        $fuel = $fuelRepository->getFuelById($id);
        $fuel = $serializer->serialize($fuel, 'json');

        return new JsonResponse($fuel, Response::HTTP_OK, [], true);
    }
}
