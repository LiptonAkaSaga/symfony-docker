<?php

namespace App\Controller;

use App\Entity\User;
use App\Formatter\ApiResponseFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    private $responseFormatter;

    public function __construct(ApiResponseFormatter $responseFormatter)
    {
        $this->responseFormatter = $responseFormatter;
    }

    #[Route('/user', name: 'user_show', methods: ['GET'])]
    public function userShow(UserInterface $user): JsonResponse
    {
        $userData = [
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ];

        return $this->responseFormatter
            ->withData($userData)
            ->withMessage('User data retrieved successfully')
            ->getResponse();
    }
}
