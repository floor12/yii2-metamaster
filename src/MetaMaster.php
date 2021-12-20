<?php

namespace floor12\metamaster;

use Yii;
use yii\base\Component;
use yii\web\Request;
use yii\web\View;

/**
 * @package floor12\metamaster
 * @property string $siteName
 * @property string $type
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $url
 * @property string $defaultImage
 * @property string $image
 * @property string $imagePath
 * @property string $web
 * @property View $view
 */
class MetaMaster extends Component
{
    /**
     * @var string
     */
    public $siteName = 'My Test Application';
    /**
     * @var string
     */
    public $web = "@app/web";
    /**
     * @var string
     */
    public $defaultImage;
    /**
     * @var string
     */
    public $protocol = 'https';
    /**
     * @var string
     */
    private $type = 'article';
    /**
     * @var Request
     */
    private $request;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $image;
    /**
     * @var string
     */
    private $imagePath;
    /**
     * @var string
     */
    private $view;

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (!$this->request)
            $this->request = Yii::$app->request;
        parent::init();
    }

    /** Site name setter
     * @param $siteName
     * @return $this
     */
    public function setSiteName(string $siteName)
    {
        $this->siteName = $siteName;
        return $this;
    }

    /** Page title setter
     * @param $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /** Url setter
     * @param $title
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /** Set request object
     * @param $title
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }


    /** OgType setter
     * @param $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /** Meta description setter
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /** Meta keyword setter is deprecated from 1.1.0
     * @param string $keywords
     * @return $this
     * @deprecated
     */
    public function setKeywords(string $keywords)
    {
        return $this;
    }

    /** Set Open Graph image tag
     * @param string $image
     * @param string|null $imagePath
     * @return $this
     */
    public function setImage(string $image, string $imagePath = null)
    {
        $this->image = $image;
        $this->imagePath = $imagePath;
        return $this;
    }

    /** Register meta tags in View
     * @param View $view
     */
    public function register(View $view)
    {
        $this->view = $view;
        $this->registerCoreInfo();
        $this->registerTitle();
        $this->registerDescription();
        $this->registerImage();
    }

    /**
     * Register core meta and og tags
     */
    private function registerCoreInfo()
    {
        $this->view->registerMetaTag(['property' => 'og:site_name', 'content' => $this->siteName]);
        $this->view->registerMetaTag(['property' => 'og:type', 'content' => $this->type]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => $this->url ?: $this->getAbsoluteUrl()]);
        $this->view->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary']);
        $this->view->registerMetaTag(['name' => 'twitter:domain', 'content' => $this->getAbsoluteUrl('')]);
        $this->view->registerMetaTag(['name' => 'twitter:site', 'content' => $this->siteName]);
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => $this->url ?: $this->getAbsoluteUrl()]);
    }

    /**
     * @param null $absoluteUrl
     * @return mixed
     */
    public function getAbsoluteUrl($absoluteUrl = null)
    {
        if ($absoluteUrl === null) {
            $absoluteUrl = $this->request->absoluteUrl;
        }

        if (substr($absoluteUrl, 0, 4) !== 'http') {
            $absoluteUrl = $this->request->getHostInfo() . $absoluteUrl;
        }

        return preg_replace('/https|http/', $this->protocol, $absoluteUrl, -1, $count);
    }

    /**
     * Register title
     */
    private function registerTitle()
    {
        if ($this->title) {
            $this->view->title = $this->title;
            $this->view->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
            $this->view->registerMetaTag(['itemprop' => 'name', 'content' => $this->title]);
        }
    }

    /**
     * Register description
     */
    private function registerDescription()
    {
        if ($this->description) {
            $this->view->registerMetaTag(['name' => 'description', 'content' => $this->description]);
            $this->view->registerMetaTag(['property' => 'og:description', 'content' => $this->description]);
            $this->view->registerMetaTag(['name' => 'twitter:description', 'content' => $this->description]);

        }
    }

    /**
     * Register image
     */
    private function registerImage()
    {
        $image = $this->image ?: $this->defaultImage;
        if ($image) {
            $imageUrl = $this->getAbsoluteUrl($image);
            $this->view->registerMetaTag(['property' => 'og:image', 'content' => $imageUrl]);
            $this->view->registerMetaTag(['property' => 'twitter:image:src', 'content' => $imageUrl]);
            $this->view->registerMetaTag(['itemprop' => 'image', 'content' => $imageUrl]);

        }

        $path = Yii::getAlias($this->imagePath ?: $this->web . $image);
        if ($this->imagePath) {
            $path = $this->imagePath;
        }
        if (file_exists($path)) {
            $imageSize = getimagesize($path);
            $this->view->registerMetaTag(['property' => 'og:image:width', 'content' => $imageSize[0]]);
            $this->view->registerMetaTag(['property' => 'og:image:height', 'content' => $imageSize[1]]);
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
