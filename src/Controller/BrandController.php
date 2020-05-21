<?php

namespace App\Controller;


use App\Entity\Brand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends AbstractController
{

    /**
     * @Route("/pro/brands", name="brands", methods={"GET"})
     */
    public function getBrands(SerializerInterface $serializer)
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->getAllBrands();
        $brands = $serializer->serialize($brands, 'json');

        return new JsonResponse($brands, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/pro/brand/{id}", name="brand", methods={"GET"})
     */
    public function getBrandById(SerializerInterface $serializer, $id)
    {
        $brandRepository = $this->getDoctrine()->getRepository(Brand::class);
        $brand = $brandRepository->getBrandById($id);
        $brand = $serializer->serialize($brand, 'json');

        return new JsonResponse($brand, Response::HTTP_OK, [], true);
    }
    /* Fonctionnent : 
            /admin/pro-add
            /brands
            /brand/
    */
}
