<?php

namespace App\Tests\Repository;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositorySearchTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->repository = $this->entityManager->getRepository(Article::class);
    }

    public function testSearchByTitle()
    {
        // Create test articles
        $article1 = new Article();
        $article1->setTitle('Test Article');
        $article1->setContent('This is a test article');
        $article1->setDateAdded(new \DateTime());

        $article2 = new Article();
        $article2->setTitle('Another Article');
        $article2->setContent('This is another article');
        $article2->setDateAdded(new \DateTime());

        $article3 = new Article();
        $article3->setTitle('Test Something Else');
        $article3->setContent('This is a different test article');
        $article3->setDateAdded(new \DateTime());

        $this->entityManager->persist($article1);
        $this->entityManager->persist($article2);
        $this->entityManager->persist($article3);
        $this->entityManager->flush();

        // Test exact match
        $results = $this->repository->searchByTitle('Test Article');
        $this->assertCount(1, $results);
        $this->assertEquals('Test Article', $results[0]->getTitle());

        // Test partial match
        $results = $this->repository->searchByTitle('Test');
        $this->assertCount(2, $results);

        // Test case insensitivity
        $results = $this->repository->searchByTitle('test');
        $this->assertCount(2, $results);

        // Test no match
        $results = $this->repository->searchByTitle('Nonexistent');
        $this->assertCount(0, $results);

        // Clean up
        $this->entityManager->remove($article1);
        $this->entityManager->remove($article2);
        $this->entityManager->remove($article3);
        $this->entityManager->flush();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
