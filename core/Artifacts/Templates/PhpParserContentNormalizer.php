<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

final readonly class PhpParserContentNormalizer
{
    private ParserFactory $parserFactory;
    private Standard $prettyPrinter;

    public function __construct()
    {
        $this->parserFactory = new ParserFactory();
        $this->prettyPrinter = new Standard();
    }

    public function normalize(string $content): string
    {
        $parser = $this->parserFactory->createForNewestSupportedVersion();

        try {
            $ast = $parser->parse($content);
        } catch (\Throwable) {
            return $content;
        }

        if ($ast === null) {
            return $content;
        }

        return $this->prettyPrinter->prettyPrintFile($ast);
    }
}
