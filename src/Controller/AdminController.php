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
     * @Route("/login", name="apiKey-admin")
     */
    public function loginAdmin(Request $request, SerializerInterface $serializer)
    {


        $loginAdmin = $request->getContent();
        $login = $serializer->deserialize($loginAdmin, Admin::class, 'json');

        $user = $this->getDoctrine()->getRepository(Admin::class)->findOneBy(['username' => $login->getUsername()]);
        if ($user == null) {
            $message = "Vos identifiants sont incorrects";
            return new JsonResponse($message, Response::HTTP_UNAUTHORIZED);
        }
        $hash = hash("sha256", $login->getPassword());
        if ($user->getPassword() == $hash) {
            $userCo = $serializer->serialize($user, 'json', ["groups" => "admin"]);
            return new JsonResponse($userCo, Response::HTTP_OK, [], true);
        } else {
            $message = "Vos identifiants sont incorrects";
            return new JsonResponse($message, Response::HTTP_UNAUTHORIZED);
        }
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
