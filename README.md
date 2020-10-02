# Favicon @ElePHPant

[![Maintainer](http://img.shields.io/badge/maintainer-@wilderamorim-blue.svg?style=flat-square)](https://twitter.com/WilderAmorim)
[![Source Code](http://img.shields.io/badge/source-wilderamorim/favicon-blue.svg?style=flat-square)](https://github.com/wilderamorim/favicon)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/elephpant/favicon.svg?style=flat-square)](https://packagist.org/packages/elephpant/favicon)
[![Latest Version](https://img.shields.io/github/release/wilderamorim/favicon.svg?style=flat-square)](https://github.com/wilderamorim/favicon/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/wilderamorim/favicon.svg?style=flat-square)](https://scrutinizer-ci.com/g/wilderamorim/favicon)
[![Quality Score](https://img.shields.io/scrutinizer/g/wilderamorim/favicon.svg?style=flat-square)](https://scrutinizer-ci.com/g/wilderamorim/favicon)
[![Total Downloads](https://img.shields.io/packagist/dt/elephpant/favicon.svg?style=flat-square)](https://packagist.org/packages/elephpant/favicon)

## Installation

### Composer (recommended)

Use [Composer](https://getcomposer.org) to install this library from Packagist:
[`elephpant/favicon`](https://packagist.org/packages/elephpant/favicon)

Run the following command from your project directory to add the dependency:

```sh
composer require elephpant/favicon "^1.0"
```

Alternatively, add the dependency directly to your `composer.json` file:

```json
"require": {
    "elephpant/favicon": "^1.0"
}
```

## Usage

```php
<?php
use ElePHPant\Favicon\Favicon;

// ORIGINAL IMAGE (recommended minimum size: 310x310 px), FOLDER, SITE URL
$favicon = (new Favicon('source.png', 'img/ico', 'https://site.com'))
    ->favicon()
    ->render();
```

```html
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!-- ========== Favicon ========== -->
    <?= $favicon; ?>
</head>
```

### Basic Result

```html
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!-- ========== Favicon ========== -->
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-57x57.png" sizes="57x57"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-114x114.png" sizes="114x114"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-72x72.png" sizes="72x72"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-144x144.png" sizes="144x144"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-60x60.png" sizes="60x60"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-120x120.png" sizes="120x120"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-76x76.png" sizes="76x76"/>
    <link rel="apple-touch-icon-precomposed" href="https://site.com/img/ico/apple-touch-icon-152x152.png" sizes="152x152"/>
    <link rel="icon" href="https://site.com/img/ico/favicon-196x196.png" sizes="196x196" type="image/png"/>
    <link rel="icon" href="https://site.com/img/ico/favicon-96x96.png" sizes="96x96" type="image/png"/>
    <link rel="icon" href="https://site.com/img/ico/favicon-32x32.png" sizes="32x32" type="image/png"/>
    <link rel="icon" href="https://site.com/img/ico/favicon-16x16.png" sizes="16x16" type="image/png"/>
    <link rel="icon" href="https://site.com/img/ico/favicon-128x128.png" sizes="128x128" type="image/png"/>
    <meta name="application-name" content="&amp;nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF"/>
    <meta name="msapplication-TileImage" content="https://site.com/img/ico/mstile-144x144.png"/>
    <meta name="msapplication-square70x70logo" content="https://site.com/img/ico/mstile-70x70.png"/>
    <meta name="msapplication-square150x150logo" content="https://site.com/img/ico/mstile-150x150.png"/>
    <meta name="msapplication-wide310x150logo" content="https://site.com/img/ico/mstile-310x150.png"/>
    <meta name="msapplication-square310x310logo" content="https://site.com/img/ico/mstile-310x310.png"/>
</head>
```

### RSS (optional parameter)

```html
<meta name="msapplication-notification" content="frequency=30;polling-uri=https://notifications.buildmypinnedsite.com/?feed=https://site.com/rss.xml.xml&amp;id=1;polling-uri2=https://notifications.buildmypinnedsite.com/?feed=https://site.com/rss.xml.xml&amp;id=2;polling-uri3=https://notifications.buildmypinnedsite.com/?feed=https://site.com/rss.xml.xml&amp;id=3;polling-uri4=https://notifications.buildmypinnedsite.com/?feed=https://site.com/rss.xml.xml&amp;id=4;polling-uri5=https://notifications.buildmypinnedsite.com/?feed=https://site.com/rss.xml.xml&amp;id=5;cycle=1"/>
```

## Contributing

No one ever has enough engineers, so we're very happy to accept contributions
via Pull Requests. For details, see [CONTRIBUTING](CONTRIBUTING.md)

## Credits

- [Wilder Amorim](https://github.com/wilderamorim) (Developer)
- [All Contributors](https://github.com/wilderamorim/favicon/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/wilderamorim/favicon/blob/master/LICENSE) for more information.