<?php

declare(strict_types=1);

use Yiisoft\Aliases\Aliases;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Definitions\Reference;
use Yiisoft\View\Twig\TemplateRenderer;

return [
    'yiisoft/yii-twig' => [
        'options' => [
            // Twig\Environment options
            'cache' => DynamicReference::to(static fn(Aliases $aliases) => $aliases->get('@runtime/twig')),
            'charset' => 'utf-8',
            'debug' => $_ENV['YII_DEBUG'],
        ],
        'extensions' => [
            //
        ],
        'loader' => [
            'paths' => [
                // Twig\Loader\FilesystemLoader paths
            ],
        ],
    ],
    'yiisoft/view' => [
        'renderers' => [
            'twig' => Reference::to(TemplateRenderer::class),
        ],
        'defaultExtension' => 'twig',
    ],
];
