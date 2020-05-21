<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Advert;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin/login", name="apiKey-admin")
     */
    public function apiKey(Request $request, SerializerInterface $serializer)
    {
        $adminRepository = $this->getDoctrine()->getRepository(Admin::class);
        $admin = $adminRepository->apiKeyAdmin('Lodevie', 'P@ssw0rd');
        $admin = $serializer->serialize($admin, 'json');
        return new JsonResponse($admin, Response::HTTP_CREATED, [], true);
    }
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function createUser(Request $request, SerializerInterface $serializer)
    {
    }

    /* Fonctionnent: admin/advertsByGarage/      
                    admin/login
                    /admin/advertsByPro/

*/
}
