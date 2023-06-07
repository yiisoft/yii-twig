<?php

declare(strict_types=1);

/**
 * @var $params array
 */

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Yiisoft\Aliases\Aliases;

return [
    Environment::class => [
        '__construct()' => ['options' => $params['yiisoft/yii-twig']['options']],
        'setExtensions()' => ['extensions' => $params['yiisoft/yii-twig']['extensions']],
    ],
    LoaderInterface::class => static fn (Aliases $aliases) => new FilesystemLoader(
        [$aliases->get('@views'), ...$params['yiisoft/yii-twig']['loader']['paths']],
        $aliases->get('@resources')
    ),
];
