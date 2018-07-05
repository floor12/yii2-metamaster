<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 05.07.2018
 * Time: 17:45
 */

namespace floor12\metamaster\tests;

use \Yii;

class MetaMasterTest extends TestCase
{

    /**
     * Проверяем изображения
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
     * Проверяем простановку заголовка
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
     * Проверяем простановку описания
     */
    public function testNoDescription()
    {
        Yii::$app->metamaster->register($this->view);
        $this->assertAttributeNotContains('<meta name="description" content="">', 'metaTags', $this->view);
    }


    public function testDescription()
    {
        $description = md5(rand(0, 99999));
        Yii::$app->metamaster->setDescription($description)->register($this->view);
        $this->assertAttributeContains('<meta name="description" content="' . $description . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:description" content="' . $description . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta name="twitter:description" content="' . $description . '">', 'metaTags', $this->view);
    }

    /**
     * Проверяем простановку ключевых слов
     */
    public function testNoKeywords()
    {
        Yii::$app->metamaster->register($this->view);
        $this->assertAttributeNotContains('<meta name="keywords" content="">', 'metaTags', $this->view);
    }


    public function testKeywords()
    {
        $keywords = md5(rand(0, 99999));
        Yii::$app->metamaster->setKeywords($keywords)->register($this->view);
        $this->assertAttributeContains('<meta name="keywords" content="' . $keywords . '">', 'metaTags', $this->view);
    }

    /**
     * Проверяем базовые ткги
     */

    public function testCoreTags()
    {
        $siteName = md5(rand(0, 99999));
        $url = md5(rand(0, 99999));
        $type = "book";


        Yii::$app->metamaster->siteName = $siteName;
        Yii::$app->metamaster->url = $url;
        Yii::$app->metamaster->type = $type;
        Yii::$app->metamaster->register($this->view);

        $this->assertAttributeContains('<meta property="og:site_name" content="' . $siteName . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta name="twitter:site" content="' . $siteName . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:type" content="' . $type . '">', 'metaTags', $this->view);
        $this->assertAttributeContains('<meta property="og:url" content="' . $url . '">', 'metaTags', $this->view);
    }


}