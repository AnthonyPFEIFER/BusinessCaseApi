<?php

namespace App\Security;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AppApiKeyAdminAuthenticator extends AbstractGuardAuthenticator
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function supports(Request $request)
    {
        return ($request->headers->has('X-Api-Key'));
    }

    public function getCredentials(Request $request)
    {
        return ($request->headers->get('X-Api-Key'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->entityManager->getRepository(Admin::class)->findOneBy(['apiKey' => $credentials]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse("Unauthorized", 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse("Missing X-Api-Key Heaaaaaaaaaaaader", 401);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
