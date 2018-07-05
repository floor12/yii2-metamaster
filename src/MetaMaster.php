<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 05.07.2018
 * Time: 11:11
 */

namespace floor12\metamaster;

use \Yii;
use yii\base\Component;
use yii\web\View;

/**
 * Class MetaMaster
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
 * @property View $_view
 */
class MetaMaster extends Component
{
    public $siteName = 'My Test Application';
    public $type = 'article';
    public $title;
    public $keywords;
    public $description;
    public $url;
    public $defaultImage;
    public $image;
    public $imagePath;
    public $web = "@app/web";
    public $request;

    private $_view;

    public function init()
    {
        if (!$this->request)
            $this->request = Yii::$app->request;
        parent::init();
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

    /** Meta description setter
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /** Meta keyword setter
     * @param string $keywords
     * @return $this
     */
    public function setKeywords(string $keywords)
    {
        $this->keywords = $keywords;
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
        $this->_view = $view;
        $this->registerCoreInfo();
        $this->registerTitle();
        $this->registerDescription();
        $this->registerKeywords();
        $this->registerImage();
    }

    /**
     * Register core meta and og tags
     */
    private function registerCoreInfo()
    {
        $this->_view->registerMetaTag(['property' => 'og:site_name', 'content' => $this->siteName]);
        $this->_view->registerMetaTag(['property' => 'og:type', 'content' => $this->type]);
        $this->_view->registerMetaTag(['property' => 'og:url', 'content' => $this->url ?: $this->request->absoluteUrl]);
        $this->_view->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary']);
        $this->_view->registerMetaTag(['name' => 'twitter:domain', 'content' => $this->request->hostInfo]);
        $this->_view->registerMetaTag(['name' => 'twitter:site', 'content' => $this->siteName]);
    }

    /**
     * Register title
     */
    private function registerTitle()
    {
        if ($this->title) {
            $this->_view->title = $this->title;
            $this->_view->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
            $this->_view->registerMetaTag(['itemprop' => 'name', 'content' => $this->title]);
        }
    }

    /**
     * Register keywords
     */
    private function registerKeywords()
    {
        if ($this->keywords) {
            $this->_view->registerMetaTag(['name' => 'keywords', 'content' => $this->keywords]);
        }
    }

    /**
     * Register description
     */
    private function registerDescription()
    {
        if ($this->description) {
            $this->_view->registerMetaTag(['name' => 'description', 'content' => $this->description]);
            $this->_view->registerMetaTag(['property' => 'og:description', 'content' => $this->description]);
            $this->_view->registerMetaTag(['name' => 'twitter:description', 'content' => $this->description]);

        }
    }

    /**
     * Register image
     */
    private function registerImage()
    {
        $image = $this->image ?: $this->defaultImage;
        if ($image) {

            $this->_view->registerMetaTag(['property' => 'og:image', 'content' => $this->request->hostInfo . $image]);
            $this->_view->registerMetaTag(['property' => 'twitter:image:src', 'content' => $this->request->hostInfo . $image]);
            $this->_view->registerMetaTag(['itemprop' => 'image', 'content' => $this->request->hostInfo . $image]);

        }

        $path = Yii::getAlias($this->imagePath ?: $this->web . $image);
        if ($this->imagePath)
            $path = $this->imagePath;
        if (file_exists($path)) {
            $imageSize = getimagesize($path);
            $this->_view->registerMetaTag(['property' => 'og:image:width', 'content' => $imageSize[0]]);
            $this->_view->registerMetaTag(['property' => 'og:image:height', 'content' => $imageSize[1]]);
        }
    }
}