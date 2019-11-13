# yii2-metamaster
[![Build Status](https://travis-ci.org/floor12/yii2-metamaster.svg?branch=master)](https://travis-ci.org/floor12/yii2-metamaster)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/floor12/yii2-metamaster/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/floor12/yii2-metamaster/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/floor12/yii2-metamaster/v/stable)](https://packagist.org/packages/floor12/yii2-metamaster)
[![Latest Unstable Version](https://poser.pugx.org/floor12/yii2-metamaster/v/unstable)](https://packagist.org/packages/floor12/yii2-metamaster)
[![Total Downloads](https://poser.pugx.org/floor12/yii2-metamaster/downloads)](https://packagist.org/packages/floor12/yii2-metamaster)
[![License](https://poser.pugx.org/floor12/yii2-metamaster/license)](https://packagist.org/packages/floor12/yii2-metamaster)

Этот компонент генерирует мета-теги, Open Graph и Twitter-card теги в темплейте вашего Yii2 приложения.

Список генерируемых тегов:
- canonical
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

Просто выполните команду:
```bash
$ composer require floor12/yii2-metamaster
```
или допишите руками в секцию require вашего composer.json.
```json
"floor12/yii2-metamaster": "dev-master"
```
После этого, необходимо подключить и сконфигурировать компонент в соответствующую секцию конфига приложения:
```php  
    'components' => [
        'metamaster' => [
            'class' => 'floor12\metamaster\MetaMaster',
            'siteName' => 'My cool new Web Site',
            'defaultImage' => '/design/export_logo.png',
        ],
    ...
```

Аттрибуты:
1. `siteName` - название проекта для Open Graph тегов;
2. `defaultImage` - относительный путь к дефолтной картинки для  Open Graph тегов;
3. `web` - yii2 алиас к веб-директории приложения (по-умолчанию `@app/web`)


Использование
------------

Компонент можно вызвать в любом месте приложения через сервис-локатор Yii2, с помощью сеттеров установить необходимые данные и зарегистрировать методом
 `register(View $view)`, передав туда объект View.

Доступные сеттеры:
```php
Metamaster::setSiteName(string $value)
Metamaster::setTitle(string $value)
Metamaster::setUrl(string $value)
Metamaster::setType(string $value)
Metamaster::setDescription(string $value)
Metamaster::setImage(string $relativePath, string $absolutePath = null)
```

Пример использования в контроллере:

```php
public function actionIndex()
   {
        Yii::$app->metamaster
                   ->setTitle("This is test page")
                   ->setDescription("This is page description")
                   ->setImage('/images/article/image.png')
                   ->register(Yii::$app->getView());
                   
        return $this->render('index');
    }
      
```

Вышеуказанные код сгенерируеют следующий код в темплейте:
```html
<title>This is test page</title>
<link href="https://your-domain.com/site/index" rel="canonical">
<meta name="description" content="This is page description">
<meta property="og:site_name" content="My cool new Web Site">
<meta property="og:type" content="article">
<meta property="og:url" content="https://your-domain.com/site/index">
<meta name="twitter:card" content="summary">
<meta name="twitter:domain" content="https://your-domain.com">
<meta name="twitter:site" content="My cool new Web Site">
<meta property="og:title" content="This is test page">
<meta itemprop="name" content="This is test page">
<meta property="og:description" content="This is page description">
<meta name="twitter:description" content="This is page description">
<meta property="og:image" content="https://your-domain.com/images/article/image.png">
<meta property="twitter:image:src" content="https://your-domain.com/images/article/image.png">
<meta itemprop="image" content="https://your-domain.com/images/article/image.png">
```

