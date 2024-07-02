<?php

namespace App\Tests\Repository;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositoryLastArticleTest extends KernelTestCase
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

    public function testGetLastArticle(): void
    {
        $article1 = new Article();
        $article1->setTitle('First Article');
        $article1->setContent('First Content');
        $article1->setDateAdded(new \DateTime('2023-01-01'));

        $article2 = new Article();
        $article2->setTitle('Last Article');
        $article2->setContent('Last Content');
        $article2->setDateAdded(new \DateTime('2023-01-02'));

        $this->entityManager->persist($article1);
        $this->entityManager->persist($article2);
        $this->entityManager->flush();

        $lastArticle = $this->repository->getLastArticle();

        $this->assertEquals('Last Article', $lastArticle->getTitle());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
