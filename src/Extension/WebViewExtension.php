<?php

namespace Yiisoft\Yii\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Yiisoft\View\WebView;

final class WebViewExtension extends AbstractExtension
{
    public function __construct(private WebView $view)
    {
    }

    public function getFunctions()
    {
        $options = ['is_safe' => ['html']];

        return [
            new TwigFunction('title', [$this->view, 'getTitle'], $options),
            new TwigFunction('head', [$this->view, 'head'], $options),
        ];
    }
}
