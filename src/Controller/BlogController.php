<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Services\ArticleProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    private ArticleRepository $articleRepository; // Zmienne klasy powinny być deklarowane
    private ArticleProvider $articleProvider;     // Także tutaj
    private FormFactoryInterface $formFactory;    // Dodaj tę deklarację

    public function __construct(
        ArticleRepository $articleRepository,
        ArticleProvider $articleProvider,
        FormFactoryInterface $formFactory // Dodanie do konstruktora
    ) {
        $this->articleRepository = $articleRepository; // Inicjalizacja
        $this->articleProvider = $articleProvider;     // Inicjalizacja
        $this->formFactory = $formFactory;             // Inicjalizacja
    }

    #[Route('/new', name: 'new_page')]
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->formFactory->create(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article created!');
            return $this->redirectToRoute('main_page');
        }

    return $this->render('blog/new.html.twig', [
        'articleForm' => $form->createView()
    ]);
    }
    #[Route('/edit/{id}', name: 'edit_article')]
    public function edit(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->formFactory->create(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article Updated');

            return $this->redirectToRoute('article', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('blog/new.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }


    #[Route('/main', name: 'main_page')]
    public function list(ArticleRepository $articleRepo, ArticleProvider $articleProvider): Response
    {
        $articles = $articleRepo->findAll();
        $transformedArticles = $articleProvider->transformDataForTwig($articles);

        return $this->render('blog/main.html.twig', ['articles' => $transformedArticles['articles'],
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_article')]
    public function deleteArticle($id, EntityManagerInterface $em)
    {
        $article = $em->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        $em->remove($article);
        $em->flush();

        $this->addFlash('success', 'Article deleted successfully');

        return $this->redirectToRoute('main_page');
    }

    #[Route('/artykuly/{id}', name: 'article')]
    public function showArticle($id):Response
    {
        $article = $this->articleRepository->find($id);
if(!$article){
    throw new NotFoundHttpException('Artykul nie zostal znaleziony');
}
$transformedArticles = $this->articleProvider->transformSingleArticleForTwig($article);
        return $this->render('blog/artykuly.html.twig',['articles' => $transformedArticles]);
    }
}
