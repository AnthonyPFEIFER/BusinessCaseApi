<?php

namespace App\Controller;


use App\Entity\Professional;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class ProfessionnelController extends AbstractController
{

    /**
     * @Route("/pro/apiKeyPro", name="apiKey-pro")
     */
    public function apiKeyPro(SerializerInterface $serializer)
    {
        $professionalRepository = $this->getDoctrine()->getRepository(Professional::class);
        $professional = $professionalRepository->apiKeyPro('Anthony', 'Anthony63');
        $professional = $serializer->serialize($professional, 'json');
        return new JsonResponse($professional, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/loginPro", name="loginPro")
     */
    public function loginPro(Request $request, SerializerInterface $serializer)
    {
        $loginPost = $request->getContent();
        $login = $serializer->deserialize($loginPost, Professional::class, 'json');
        $user = $this->getDoctrine()->getRepository(Professional::class)->findOneBy(['username' => $login->getUsername()]);

        if ($user == null) {
            $message = "Vos identifiants sont incorrects";
            return new JsonResponse($message, Response::HTTP_UNAUTHORIZED);
        }
        $hash = hash("sha256", $login->getPassword());
        if ($user->getPassword() == $hash) {
            $userCo = $serializer->serialize($user, 'json', ["groups" => "pros"]);
            return new JsonResponse($userCo, Response::HTTP_OK, [], true);
        } else {
            $message = "Vos identifiants sont incorrects";
            return new JsonResponse($message, Response::HTTP_UNAUTHORIZED);
        }
    }
    /**
     * @Route("/admin/pro-add", name="add-pro", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer)
    {
        $pro = $serializer->deserialize($request->getContent(), Professional::class, 'json');
        $pro->setPassword(hash('sha256', $pro->getPassword()));
        $pro->setApiKey(hash('sha256', uniqid()));
        $pro->setRoles(['ROLE_PRO']);

        $this->getDoctrine()->getManager()->persist($pro);
        $this->getDoctrine()->getManager()->flush();

        $pro = $serializer->serialize($pro, 'json');

        return new JsonResponse($pro, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/admin/professionnels", name="pros")
     */
    public function getProfessionnels(SerializerInterface $serializer)
    {
        $professionalRepository = $this->getDoctrine()->getRepository(Professional::class);
        $professionals = $professionalRepository->getPros();
        $professionals = $serializer->serialize($professionals, 'json');
        return new JsonResponse($professionals, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/admin/professionnel/{id}", name="professionnel")
     */
    public function getProfessionnel(SerializerInterface $serializer, $id)
    {
        $professionalRepository = $this->getDoctrine()->getRepository(Professional::class);
        $professional = $professionalRepository->findOneBy(['id' => $id]);

        $professional = $serializer->serialize($professional, 'json', ['groups' => 'pros']);
        return new JsonResponse($professional, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/pro/edit/{id}", name="edit-pro", methods={"PUT"})
     */
    public function edit(Request $request, SerializerInterface $serializer, $id)
    {
        $data = $request->getContent();
        $proRepository = $this->getDoctrine()->getRepository(Professional::class);
        $editPro = $proRepository->findOneBy(["id" => $id]);
        $serializer->deserialize(
            $data,
            Professional::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $editPro]
        );
        $this->getDoctrine()->getManager()->persist($editPro);
        $this->getDoctrine()->getManager()->flush();

        $professional = $serializer->serialize($editPro, 'json', ['groups' => 'pros']);

        return new JsonResponse($professional, Response::HTTP_CREATED, [], true);
    }


    /**
     * @Route("/admin/pro-delete/{id}", name="delete-pro", methods={"DELETE"})
     */
    public function delete(Request $request, SerializerInterface $serializer, $id)
    {
        $professionalRepository = $this->getDoctrine()->getRepository(Professional::class);
        $professional = $professionalRepository->findOneBy(['id' => $id]);


        $this->getDoctrine()->getManager()->remove($professional);
        $this->getDoctrine()->getManager()->flush();

        $professional = $serializer->serialize($professional, 'json');

        return new JsonResponse($professional, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/admin/pro-number", name="number-pro", methods={"GET"})
     */
    public function getNumberofPros(SerializerInterface $serializer)
    {
        $professionnels = $this->getDoctrine()->getRepository(Professional::class)->getProNumber();
        $professionnels = $serializer->serialize($professionnels, 'json');

        return new JsonResponse($professionnels, Response::HTTP_OK, [], true);
    }
}
