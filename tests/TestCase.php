<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 07.01.2018
 * Time: 12:40
 */

namespace floor12\metamaster\tests;

use yii\console\Application;
use \Yii;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    protected $request;
    protected $view;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->request = $this->getMock('\yii\web\Request', []);
        $this->mockApplication();
        Yii::$app->metamaster->request = $this->request;
        $this->view = Yii::$app->getView();
    }


    /**
     * @inheritdoc
     */
    protected function tearDown()
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
                ],
            ]
        ]);
    }

    /**
     * Убиваем приложение
     */
    protected function destroyApplication()
    {
        \Yii::$app = null;
    }
}