<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class PictureController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @Route("/pro/picture-add/{id}", name="add-picture", methods={"POST"})
     */

    public function addPicture(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);

        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $advertRepository->findOneBy(['id' => $id]);

        $picture = new Picture();
        $picture->setAdvert($advert);
        $picture->setData($data['picture']);

        $this->getDoctrine()->getManager()->persist($picture);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/pro/picturesByAdvert/{id}", name="picturesByAdvert", methods={"GET"})
     */
    public function getPicturesByAdvert(Request $request, SerializerInterface $serializer, $id)
    {

        $pictureRepository = $this->getDoctrine()->getRepository(Picture::class);
        $picture = $pictureRepository->getPicturesByAdvert($id);
        $picture = $serializer->serialize($picture, 'json');

        return new JsonResponse($picture, Response::HTTP_OK, [], true);
    }
}





/**
 * 
        if (!is_dir('pictures')) {
            mkdir('pictures');
        }
        $picture = $request->files->get($image); // picture = nom de l'input du form / Récupère les données de l'image 
        $filename = \uniqid();
        $picture->move('public/pictures/', $picture, $filename);

        $pictureUrl = 'public/pictures/' . $filename;

        $pictureRepository = $this->getDoctrine()->getRepository(Picture::class);
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $advertRepository->findOneBy(['id' => $id]);

        $pictureRepository->setData($pictureUrl);
        $pictureRepository->setAdvert($advert);


        $this->getDoctrine()->getManager()->persist($pictureRepository);
        $this->getDoctrine()->getManager()->flush();


        $pictureSerialize = $serializer->serialize($pictureRepository, 'json');
        return new JsonResponse($pictureSerialize, Response::HTTP_CREATED, [], true);
 */
