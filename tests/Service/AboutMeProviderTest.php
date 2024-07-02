<?php

namespace App\Tests\Service;

use App\Entity\AboutMeInfo;
use App\Services\AboutMeInfoProvider;
use PHPUnit\Framework\TestCase;

class AboutMeProviderTest extends TestCase
{
    public function testTransformSingleInfoForTwig()
    {
        $provider = new AboutMeInfoProvider();

        $aboutMeInfo = new AboutMeInfo();
        $aboutMeInfo->setInfoKey('name');
        $aboutMeInfo->setValue('John Doe');

        $result = $provider->transformSingleInfoForTwig($aboutMeInfo);

        $this->assertArrayHasKey('id', $result);
        $this->assertEquals('name', $result['infoKey']);
        $this->assertEquals('John Doe', $result['value']);
        $this->assertStringStartsWith('/about-me/edit/', $result['editLink']);
        $this->assertStringStartsWith('/about-me/delete/', $result['deleteLink']);
    }
}
