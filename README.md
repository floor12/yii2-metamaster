# yii2-metamaster
[![Build Status](https://travis-ci.org/floor12/yii2-metamaster.svg?branch=master)](https://travis-ci.org/floor12/yii2-metamaster)
[![Latest Stable Version](https://poser.pugx.org/floor12/yii2-metamaster/v/stable)](https://packagist.org/packages/floor12/yii2-metamaster)
[![Latest Unstable Version](https://poser.pugx.org/floor12/yii2-metamaster/v/unstable)](https://packagist.org/packages/floor12/yii2-metamaster)
[![Total Downloads](https://poser.pugx.org/floor12/yii2-metamaster/downloads)](https://packagist.org/packages/floor12/yii2-metamaster)
[![License](https://poser.pugx.org/floor12/yii2-metamaster/license)](https://packagist.org/packages/floor12/yii2-metamaster)

*Этот файл так же доступен на [русском языке](README_RUS.md).*

This is a component for generate some Meta, Open Graph and Twitter tags in a template header of Yii2 app.

This is a list of supported tags:
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

Instalation
------------

Just run:
```bash
$ composer require floor12/yii2-metamaster
```
or add this to the require section of your composer.json.
```json
"floor12/yii2-metamaster": "dev-master"
```

After that, include some basic metamaster data into `components` section of application config.
```php  
    'components' => [
        'metamaster' => [
            'class' => 'floor12\metamaster\MetaMaster',
            'siteName' => 'My cool new Web Site',
            'defaultImage' => '/design/export_logo.png',
        ],
    ...
```

Attributes:
1. `siteName` - name of project to show in Open Graph tags;
2. `defaultImage` - web relative path to default image for Open Graph tags;
3. `web` - yii2 alias to web path to read image width and height for Open Graph tags (default is `@app/web`)


Usage
------------

Its possible to use in any place of your app. Just user setters and then call the `register(View $view)` method with View object passed into it.

Allowed setters:
```php
Metamaster::setSiteName(string)
Metamaster::setTitle(string)
Metamaster::setUrl(string)
Metamaster::setType(string)
Metamaster::setDescription(string)
Metamaster::setImage(string $)
```

For example, using in controller:

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

It will generate all you need in template:
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

