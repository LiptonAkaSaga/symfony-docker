<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Article;

class ArticleProvider
{
    public function transformDataForTwig(array $articles): array
    {
        $transformedData = [];
        foreach ($articles as $article) {
            $transformedData[] = $this->transformSingleArticleForTwig($article);
        }
        return $transformedData;
    }

    public function transformSingleArticleForTwig(Article $article, bool $truncateContent = true): array
    {
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $truncateContent ? $this->truncateContent($article->getContent(), 150) : $article->getContent(),
            'dateAdded' => $article->getDateAdded()->format('Y-m-d H:i:s'),
            'link' => '/article/' . $article->getId(),
        ];
    }

    public function prepareNewArticleData(): array
    {
        return [
            'title' => '',
            'content' => '',
            'images' => []
        ];
    }

    private function truncateContent(string $content, int $length = 150): string
    {
        if (strlen($content) <= $length) {
            return $content;
        }

        return substr($content, 0, $length) . '...';
    }
}
