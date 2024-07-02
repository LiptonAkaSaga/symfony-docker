<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Services\ArticleProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    private ArticleProvider $articleProvider;

    public function __construct(ArticleProvider $articleProvider)
    {
        $this->articleProvider = $articleProvider;
    }

    #[Route('/article/new', name: 'article_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/articles', name: 'article_list')]
    public function list(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAllOrderedByNewest();
        $transformedArticles = $this->articleProvider->transformDataForTwig($articles);

        return $this->render('blog/list.html.twig', [
            'articles' => $transformedArticles,
        ]);
    }

    #[Route('/article/edit/{id}', name: 'article_edit')]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }

        return $this->render('blog/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/delete/{id}', name: 'article_delete')]
    public function delete(Article $article, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('article_list');
    }

    #[Route('/article/{id}', name: 'article_show')]
    public function show(Article $article): Response
    {
        $transformedArticle = $this->articleProvider->transformSingleArticleForTwig($article, false);

        return $this->render('blog/show.html.twig', [
            'article' => $transformedArticle,
        ]);
    }

    #[Route('/search/{search_slug}', name: 'search_articles')]
    public function search(string $search_slug, Request $request, ArticleRepository $articleRepository): Response
    {
        $query = $request->query->get('query', $search_slug);
        $articles = $articleRepository->searchByTitle($query);

        return $this->render('blog/search_result.html.twig', [
            'articles' => $this->articleProvider->transformDataForTwig($articles),
            'query' => $query
        ]);
    }
}
