<?php

declare(strict_types=1);

namespace App\Services;

class AboutMeInfoProvider
{
    public function transformAboutMeInfo(array $aboutMeInfo): array
    {
return[
    'key' => $aboutMeInfo->getKey(),
    'value' => $aboutMeInfo->getValue(),
];

    }
}
