<?php

namespace App\DataFixtures;

use App\Entity\AboutMeInfo;
use App\Entity\Article;
use App\Entity\InformationAboutMe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article->setTitle('Article 1');
        $article->setContent('Article 1 content');
        $article->setDateAdded(new \DateTime('now'));
        $manager->persist($article);
        $article = new Article();
        $article->setTitle('Article 2');
        $article->setContent('Article 2 content is quite short and lazy article but it is still an article so it is fine. It is not a long article but it is still an article. ');
        $article->setDateAdded(new \DateTime('now'));
        $manager->persist($article);
        $article = new Article();
        $article->setTitle('Article 3');
        $article->setContent('Article number 3 is a example of lazy article but quite long in comparison with previous two');
        $article->setDateAdded(new \DateTime('now'));
        $manager->persist($article);

        $me = new AboutMeInfo();
        $me->setInfoKey('Name');
        $me->setValue('Bob');
        $manager->persist($me);

        $me = new AboutMeInfo();
        $me->setInfoKey('Age');
        $me->setValue('23');
        $manager->persist($me);

        $me = new AboutMeInfo();
        $me->setInfoKey('Description');
        $me->setValue('Nice guy');
        $manager->persist($me);

        $manager->flush();
    }
}
