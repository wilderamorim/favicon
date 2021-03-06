<?php

require dirname(__DIR__, 1) . '/vendor/autoload.php';


use ElePHPant\Favicon\Favicon;

$favicon = (new Favicon(
    'source.png',
    'assets/images/favicon',
    'http://localhost/packagist.org/favicon/example',
    'ElePHPant',
    '#4F5B93',
    null,
    true
))->favicon()->render();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- ========== Favicon ========== -->
    <?= $favicon; ?>
</head>
<body>
<h1>Favicon @ElePHPant</h1>
</body>
</html>
