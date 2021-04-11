<?php


namespace floor12\metamaster\tests;

use floor12\metamaster\MetaMaster;
use Yii;
use yii\console\Application;
use yii\web\Request;
use yii\web\View;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var View
     */
    protected $view;
    /**
     * @var MetaMaster
     */
    protected $metamaster;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplication();
        $this->view = Yii::$app->getView();
        $this->metamaster = Yii::$app->metamaster;
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        $this->destroyApplication();
        parent::tearDown();
    }

    /**
     *  Запускаем приложение
     */
    protected function mockApplication()
    {
        new Application([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'runtimePath' => __DIR__ . '/runtime',
            'components' => [
                'metamaster' => [
                    'class' => 'floor12\metamaster\MetaMaster',
                    'defaultImage' => 'default.jpg'
                ],
            ]
        ]);
        Yii::$app->metamaster->setRequest($this->createMock('\yii\web\Request', []));
    }

    /**
     * Убиваем приложение
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }
}