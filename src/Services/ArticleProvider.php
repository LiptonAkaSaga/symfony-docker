<?php

declare(strict_types=1);

namespace App\Services;

class ArticleProvider
{
    public function transformDataForTwig(array $articles): array
    {
        $transformedData = [];
        foreach ($articles as $article) {
            $transformedData['articles'][] = [
                'title' => $article->getTitle(),
                'content' => substr($article->getContent(), 0, 100) . '...',
                'link' => 'article/' . $article->getId(),
                'id' => $article->getId(),
                'date' => $article->getdateadded()->format('Y-m-d'),
            ];
        }
        return $transformedData;
    }

    public function transformSingleArticleForTwig(\App\Entity\Article $article): array
    {
        return [
            'title' => $article->getTitle(),
            'content' => substr($article->getContent(), 0, 100) . '...',
            'link' => 'article/' . $article->getId(),
            'id' => $article->getId(),
            'date' => $article->getdateadded()->format('Y-m-d'),
        ];
    }
}



