<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Twig\Tests\Extension;

use DOMDocument;
use DOMElement;
use DOMXPath;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Yiisoft\View\WebView;
use Yiisoft\Yii\Twig\Extension\WebViewExtension;

use function ob_get_clean;
use function ob_start;

final class WebViewExtensionTest extends TestCase
{
    public function testTitleIsEmptyWhenNoTitleIsSet(): void
    {
        $twig = $this->createTwig(new WebView(), '<title>{{ title() }}</title>');

        $result = $twig->render('page');

        self::assertSame('<title></title>', $result);
    }

    public function testTitleUsesCurrentViewTitleWithoutDoubleEscaping(): void
    {
        $view = new WebView();
        $twig = $this->createTwig($view, '<title>{{ title() }}</title><p>{{ content }}</p>');
        $view->setTitle('Documentation &amp; examples');

        $result = $twig->render('page', ['content' => '<b>Getting started</b>']);

        self::assertSame(
            '<title>Documentation &amp; examples</title><p>&lt;b&gt;Getting started&lt;/b&gt;</p>',
            $result,
        );

        $view->setTitle('API reference');

        self::assertSame(
            '<title>API reference</title><p></p>',
            $twig->render('page', ['content' => '']),
        );
    }

    public function testHeadIncludesTagsRegisteredAfterTheTemplateIsRendered(): void
    {
        $view = new WebView();
        $twig = $this->createTwig($view, '<!DOCTYPE html><html><head>{{ head() }}</head><body></body></html>');

        ob_start();
        $view->beginPage();
        try {
            echo $twig->render('page');
            $view->registerMeta(['name' => 'description', 'content' => 'Documentation & examples']);
        } finally {
            $view->endPage();
            $result = ob_get_clean();
        }

        $document = new DOMDocument();
        $document->loadHTML($result);
        $tags = (new DOMXPath($document))->query('/html/head/meta[@name="description"]');
        self::assertCount(1, $tags);
        $meta = $tags->item(0);
        self::assertInstanceOf(DOMElement::class, $meta);
        self::assertSame('Documentation & examples', $meta->getAttribute('content'));
    }

    private function createTwig(WebView $view, string $template): Environment
    {
        $twig = new Environment(new ArrayLoader(['page' => $template]), ['autoescape' => 'html']);
        $twig->addExtension(new WebViewExtension($view));

        return $twig;
    }
}
