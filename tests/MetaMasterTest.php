<?php

namespace floor12\metamaster\tests;

class MetaMasterTest extends TestCase
{

    /**
     * Test custom image setting up.
     */
    public function testDeafultImage()
    {
        $this->metamaster->getRequest()->method('getHostInfo')->willReturn('https://test.url');

        $this->metamaster
            ->register($this->view);

        $fullImagePath = 'https://test.url' . $this->metamaster->defaultImage;

        $this->assertTrue(in_array('<meta property="twitter:image:src" content="' . $fullImagePath . '">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta property="og:image" content="' . $fullImagePath . '">', $this->view->metaTags));
    }

    /**
     * Test custom image setting up.
     */
    public function testImage()
    {
        $filename = '/testImage.png';
        $this->metamaster->getRequest()->method('getHostInfo')->willReturn('https://test.url');


        $this->metamaster
            ->setImage($filename, __DIR__ . $filename)
            ->register($this->view);

        $fullImagePath = 'https://test.url' . $filename;

        $this->assertTrue(in_array('<meta property="twitter:image:src" content="' . $fullImagePath . '">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta property="og:image" content="' . $fullImagePath . '">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta property="og:image:width" content="300">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta property="og:image:height" content="300">', $this->view->metaTags));
    }

    /**
     * Page title testing
     */
    public function testTitle()
    {
        $title = md5(rand(0, 99999));
        $this->metamaster->setTitle($title)->register($this->view);
        $this->assertEquals($this->view->title, $title);
        $this->assertTrue(in_array('<meta property="og:title" content="' . $title . '">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta itemprop="name" content="' . $title . '">', $this->view->metaTags));
    }

    /**
     * Description testing
     */
    public function testNoDescription()
    {
        $this->metamaster->register($this->view);
        $this->assertFalse(in_array('<meta name="description" content="">', $this->view->metaTags));
    }

    /**
     * Description testing
     */
    public function testDescription()
    {
        $description = md5(rand(0, 99999));
        $this->metamaster->setDescription($description)->register($this->view);
        $this->assertTrue(in_array('<meta name="description" content="' . $description . '">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta property="og:description" content="' . $description . '">', $this->view->metaTags));
        $this->assertTrue(in_array('<meta name="twitter:description" content="' . $description . '">', $this->view->metaTags));
    }


    /**
     * Core tags testing
     */

    public function testGetAbsoluteUrlHttpsToHttps()
    {
        $this->metamaster->protocol = 'https';
        $this->metamaster->getRequest()->method('getHostInfo')->willReturn('http://test.url');
        $url = '/test';
        $this->assertEquals('https://test.url/test', $this->metamaster->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlHttpToHttps()
    {
        $this->metamaster->protocol = 'https';
        $this->metamaster->getRequest()->method('getHostInfo')->willReturn('http://test.url');
        $url = '/test';
        $this->assertEquals('https://test.url/test', $this->metamaster->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlHttpsToHttp()
    {
        $this->metamaster->protocol = 'http';
        $this->metamaster->getRequest()->method('getHostInfo')->willReturn('https://test.url');
        $url = '/test';
        $this->assertEquals('http://test.url/test', $this->metamaster->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlHttpToHttp()
    {
        $this->metamaster->protocol = 'http';
        $this->metamaster->getRequest()->method('getHostInfo')->willReturn('https://test.url');
        $url = '/test';
        $this->assertEquals('http://test.url/test', $this->metamaster->getAbsoluteUrl($url));
    }

}