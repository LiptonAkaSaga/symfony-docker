<?php

namespace App\DataFixtures;
use App\Entity\Image;
use App\Entity\AboutMeInfo;
use App\Entity\Article;
use App\Entity\InformationAboutMe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

class AppFixtures extends Fixture
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }


    public function load(ObjectManager $manager): void
    {
        $imageNames = [
            'image1.jpg',
            'image2.jpg',
            'image3.jpg',
            'image4.jpg',
            'image5.jpg',
            'image6.jpg',
            'image7.jpg',
            'image8.jpg',
            'image9.jpg',
            'image10.jpg',
        ];
        $contents =[
            'W ostatnich dekadach technologia znacznie zmieniła sposób, w jaki uczymy się i nauczamy. Od interaktywnych tablic po e-learning, technologia staje się integralną częścią edukacji. Uczniowie mają dostęp do nieskończonych zasobów online, co zwiększa ich możliwości samodzielnego zdobywania wiedzy. Z kolei nauczyciele mogą korzystać z różnorodnych narzędzi do tworzenia bardziej angażujących lekcji. Jednakże, z tą ewolucją wiążą się również wyzwania, takie jak zapewnienie równego dostępu do technologii dla wszystkich uczniów oraz radzenie sobie z problemami wynikającymi z nadmiernej ekspozycji na ekrany.',
            'Zrównoważony rozwój stał się kluczowym pojęciem w dzisiejszych czasach, gdy zmiany klimatyczne i degradacja środowiska stają się coraz bardziej widoczne. Dążenie do zrównoważonego rozwoju oznacza podejmowanie działań, które pozwalają na zaspokojenie obecnych potrzeb bez narażania przyszłych pokoleń na brak zasobów. Inicjatywy takie jak recykling, odnawialne źródła energii oraz ochrona bioróżnorodności stają się nieodzownym elementem polityk rządowych i strategii biznesowych. Ważne jest również zwiększanie świadomości społecznej na temat znaczenia ochrony środowiska.',
            'Sztuczna inteligencja (SI) rewolucjonizuje medycynę, oferując nowe możliwości w diagnostyce, leczeniu i badaniach naukowych. Algorytmy SI mogą analizować ogromne ilości danych medycznych, pomagając w wykrywaniu chorób na wczesnym etapie oraz proponowaniu spersonalizowanych terapii. Przykładem może być wykorzystanie SI w analizie obrazów medycznych, co przyspiesza diagnozowanie raka. Jednakże, implementacja SI w medycynie wymaga staranności, aby zapewnić bezpieczeństwo i prywatność pacjentów oraz uniknąć błędów diagnostycznych.',
            'Moda w XXI wieku przechodzi dynamiczne zmiany, odzwierciedlając zarówno technologiczne innowacje, jak i zmieniające się wartości społeczne. Coraz większy nacisk kładzie się na zrównoważoną produkcję odzieży oraz etyczne praktyki w przemyśle modowym. Technologie takie jak druk 3D i sztuczna inteligencja pozwalają na tworzenie bardziej innowacyjnych i personalizowanych projektów. Wzrasta również znaczenie mody wirtualnej i cyfrowej, co otwiera nowe możliwości dla kreatywnych wyrazów i interakcji z konsumentami.',
            'Media społecznościowe znacząco zmieniły sposób, w jaki komunikujemy się i nawiązujemy relacje. Dzięki nim możliwe jest utrzymywanie kontaktu z ludźmi na całym świecie oraz łatwe dzielenie się swoimi przeżyciami i myślami. Jednakże, z tymi korzyściami wiążą się również wyzwania. Nadmierne korzystanie z mediów społecznościowych może prowadzić do izolacji społecznej, niskiego poczucia własnej wartości oraz problemów z koncentracją. Kluczowe jest zatem znalezienie równowagi w ich użytkowaniu oraz promowanie zdrowych nawyków cyfrowych.',
        ];

        $titles = [
            'Wpływ technologii na edukację w XXI wieku',
            'Ochrona środowiska a zrównoważony rozwój',
            'Rola sztucznej inteligencji w medycynie',
            'Ewolucja mody w XXI wieku',
            'Wpływ mediów społecznościowych na relacje międzyludzkie',
        ];

        for ($i = 0; $i < 5; $i++) {
            $article = new Article();
            $article->setTitle($titles[$i]);
            $article->setContent($contents[$i]);
            $article->setDateAdded(new \DateTime());

            for ($j = 0; $j < 2; $j++) {
                $imageIndex = $i * 2 + $j;
                $image = new Image();
                $image->setTitle("Image " . ($j + 1) . " for " . $titles[$i]);
                $image->setPath('/images/' . $imageNames[$imageIndex]);
                $image->setAlt("Alt text for image " . ($j + 1) . " of " . $titles[$i]);
                $image->setArticle($article);

                $article->addImage($image);
                $manager->persist($image);
                $sourcePath = __DIR__ . '/sample_images/' . $imageNames[$imageIndex];
                $targetPath = 'public/images/' . $imageNames[$imageIndex];
                if ($this->filesystem->exists($sourcePath)) {
                    $this->filesystem->copy($sourcePath, $targetPath, true);
                }

            }

            $manager->persist($article);
        }

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
