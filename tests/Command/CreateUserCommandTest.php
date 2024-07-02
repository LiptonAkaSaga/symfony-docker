<?php

namespace App\Tests\Command;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testExecute()
    {
        $application = new Application(self::$kernel);

        $command = $application->find('app:create-user');
        $commandTester = new CommandTester($command);

        // Generate a unique email
        $uniqueEmail = 'test_' . uniqid() . '@example.com';

        $commandTester->execute([
            'email' => $uniqueEmail,
            'password' => 'testpassword'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('User successfully created!', $output);

        // Check if the user was actually created in the database
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $uniqueEmail]);

        $this->assertNotNull($user);
        $this->assertEquals($uniqueEmail, $user->getEmail());

        // Clean up
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
