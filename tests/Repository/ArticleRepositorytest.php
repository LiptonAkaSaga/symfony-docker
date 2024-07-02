<?php

namespace App\Tests\Repository;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositoryTest extends KernelTestCase
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

    public function testSearchByTitle(): void
    {
        $article = new Article();
        $article->setTitle('Test Article');
        $article->setContent('Test Content');
        $article->setDateAdded(new \DateTime());

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        $result = $this->repository->searchByTitle('Test');

        $this->assertCount(1, $result);
        $this->assertEquals('Test Article', $result[0]->getTitle());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
