<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\CloningVisitor;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;

final readonly class PhpParserContentNormalizer
{
    private ParserFactory $parserFactory;
    private Standard $prettyPrinter;
    private string $format;

    public function __construct(
        ConfigurationInterface $configuration,
    ) {
        $this->parserFactory = new ParserFactory();
        $this->prettyPrinter = new Standard();
        $this->format = (string) $configuration->get('php_parser.format');
    }

    public function normalize(string $content): string
    {
        $parser = $this->parserFactory->createForNewestSupportedVersion();

        try {
            $originalAst = $parser->parse($content);
        } catch (\Throwable) {
            return $content;
        }

        if ($originalAst === null) {
            return $content;
        }

        if ($this->format === 'pretty_print') {
            return $this->prettyPrinter->prettyPrintFile($originalAst);
        }

        if ($this->format !== 'format_preserving') {
            return $content;
        }

        $traverser = new NodeTraverser(
            new CloningVisitor(),
        );

        $ast = $traverser->traverse($originalAst);

        try {
            return $this->prettyPrinter->printFormatPreserving(
                $ast,
                $originalAst,
                $parser->getTokens(),
            );
        } catch (\Throwable) {
            return $content;
        }
    }
}
