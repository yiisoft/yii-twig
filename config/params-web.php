<?php

declare(strict_types=1);

use Yiisoft\Definitions\Reference;
use Yiisoft\Yii\Twig\Extension\WebViewExtension;

return [
    'yiisoft/yii-twig' => [
        'extensions' => [
            Reference::to(WebViewExtension::class),
        ],
    ],
];
