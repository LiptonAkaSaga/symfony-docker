<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;

class MainPageController extends AbstractController
{
    public function __construct(private ArticleRepository $articleRepository)
    {

    }
    #[Route('/', name: 'app_main_page')]
    public function index(): Response
    {
        $lastArticle = $this->articleRepository->getLastArticle();
        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController', 'lastArticle' => $lastArticle
        ]);
    }
}
