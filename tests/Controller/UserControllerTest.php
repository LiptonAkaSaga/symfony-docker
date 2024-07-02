<?php

namespace App\Tests\Controller;

use App\Controller\UserController;
use App\Entity\User;
use App\Formatter\ApiResponseFormatter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserControllerTest extends TestCase
{
    public function testUserShow()
    {
        $user = $this->createMock(User::class);
        $user->method('getEmail')->willReturn('test@example.com');
        $user->method('getRoles')->willReturn(['ROLE_USER']);

        $formatter = new ApiResponseFormatter();

        $controller = new UserController($formatter);
        $response = $controller->userShow($user);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('test@example.com', $content['data']['email']);
        $this->assertEquals(['ROLE_USER'], $content['data']['roles']);
        $this->assertEquals('User data retrieved successfully', $content['message']);
    }
}
