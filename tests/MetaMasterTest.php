<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 05.07.2018
 * Time: 17:45
 */

namespace floor12\metamaster\tests;

use floor12\metamaster\MetaMaster;
use Yii;

class MetaMasterTest extends TestCase
{

    /**
     * Test custom image setting up.
     */
    public function testDeafultImage()
    {
        Yii::$app->metamaster
            ->register($this->view);

        $this->assertAttributeContains('<meta property="twitter:image:src" content="' . Yii::$app->metamaster->defaultImage . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:image" content="' . Yii::$app->metamaster->defaultImage . '">', 'metaTags', $this->view);
    }

    /**
     * Test custom image setting up.
     */
    public function testImage()
    {
        $filename = '/testImage.png';
        Yii::$app->metamaster
            ->setImage($filename, __DIR__ . $filename)
            ->register($this->view);

        $this->assertAttributeContains('<meta property="twitter:image:src" content="' . $filename . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:image" content="' . $filename . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:image:width" content="300">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:image:height" content="300">', 'metaTags', $this->view);
    }

    /**
     * Page title testing
     */
    public function testTitle()
    {
        $title = md5(rand(0, 99999));
        Yii::$app->metamaster->setTitle($title)->register($this->view);
        $this->assertEquals($this->view->title, $title);
        $this->assertAttributeContains('<meta property="og:title" content="' . $title . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta itemprop="name" content="' . $title . '">', 'metaTags', $this->view);
    }

    /**
     * Description testing
     */
    public function testNoDescription()
    {
        Yii::$app->metamaster->register($this->view);
        $this->assertAttributeNotContains('<meta name="description" content="">', 'metaTags', $this->view);
    }

    /**
     * Description testing
     */
    public function testDescription()
    {
        $description = md5(rand(0, 99999));
        Yii::$app->metamaster->setDescription($description)->register($this->view);
        $this->assertAttributeContains('<meta name="description" content="' . $description . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:description" content="' . $description . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta name="twitter:description" content="' . $description . '">', 'metaTags', $this->view);
    }


    /**
     * Core tags testing
     */

    public function testGetAbsoluteUrlHttpsToHttps()
    {
        $metamaster = new MetaMaster();
        $metamaster->protocol = 'https';
        $url = 'https://test.ru';
        $this->assertEquals('https://test.ru', $metamaster->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlHttpToHttps()
    {
        $metamaster = new MetaMaster();
        $metamaster->protocol = 'https';
        $url = 'http://test.ru';
        $this->assertEquals('https://test.ru', $metamaster->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlHttpsToHttp()
    {
        $metamaster = new MetaMaster();
        $metamaster->protocol = 'http';
        $url = 'https://test.ru';
        $this->assertEquals('http://test.ru', $metamaster->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlHttpToHttp()
    {
        $metamaster = new MetaMaster();
        $metamaster->protocol = 'http';
        $url = 'http://test.ru';
        $this->assertEquals('http://test.ru', $metamaster->getAbsoluteUrl($url));
    }

}