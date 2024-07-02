<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\AboutMeInfo;

class AboutMeInfoProvider
{
    public function transformDataForTwig(array $aboutMeInfos): array
    {
        $transformedData = [];
        foreach ($aboutMeInfos as $info) {
            $transformedData[] = $this->transformSingleInfoForTwig($info);
        }
        return $transformedData;
    }

    public function transformSingleInfoForTwig(AboutMeInfo $info): array
    {
        return [
            'id' => $info->getId(),
            'infoKey' => $info->getInfoKey(),
            'value' => $info->getValue(),
            'editLink' => '/about-me/edit/' . $info->getId(),
            'deleteLink' => '/about-me/delete/' . $info->getId(),
        ];
    }
}
