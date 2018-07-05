#yii2-metamaster
Универсальный компонент организующий META и Open Graph теги в вашем приложении.

Список поддерживаемых тегов:
- head title
- meta description
- meta keywords
- og:sitename
- og:type
- og:url
- og:title
- og:description
- og:image
- og:image:width
- og:image:height
- twitter:card
- twitter:domain
- twitter:site
- twitter:description
- twitter:image:src
- itemprop:name
- itemprop:image

Установка
------------

#### Ставим компонент

Выполняем команду
```bash
$ composer require floor12/yii2-metamaster
```

иди добавляем в секцию "requred" файла composer.json
```json
"floor12/yii2-metamaster": "dev-master"
```


###Добавляем компонент в конфиг приложения
```php  
    'components' => [
        'metamaster' => [
            'class' => 'floor12\metamaster\MetaMaster',
            'siteName' => 'My cool new Web Site',
            'defaultImage' => '/design/export_logo.png',
        ],
    ...
```

Параметры:

1. `siteName` - название сайта для Open Graph тегов.
2. `defaultImage` - Путь к дефолтной картинке для экспорта в соцсети через Open Graph

Остальные атрибуты смотрите в исходном коде класса.


Использование
------------
Использовать можно в любоме месте, вызывая метод `register`, передавая туда объект View. Например в контроллере:
```php

public function actionIndex()
   {
        Yii::$app->metamaster->title = "Тестовая страница";
        Yii::$app->metamaster->description = "Это тестовое описание страницы";
        Yii::$app->metamaster->kewords = "ключевые слова";
        Yii::$app->metamaster->image = "/test/image.png";
        Yii::$app->metamaster->register(Yii::$app->getView());
        return $this->render('index');
    }
```
При этом будут сформированы и зарегистрированы все теги, указанные в начале этого файла.

Существует более простой вызов с использованием стрелочных функции:
```php
public function actionIndex()
   {
        Yii::$app->metamaster
                   ->setTitle("Тестовая страница")
                   ->setDescription("Это тестовое описание страницы")
                   ->setImage('/images/article/image.png')
                   ->register(Yii::$app->getView());
                   
        return $this->render('index');
    }
      
```

При использовании изображений, их фактический размер определяется автоматически и прописывается в соответствующие og-теги.