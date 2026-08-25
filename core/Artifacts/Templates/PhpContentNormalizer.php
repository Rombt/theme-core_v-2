<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

final class PhpContentNormalizer
{
    public function normalize(string $content): string
    {
        $tokens = token_get_all($content);

        $result = '';
        foreach ($tokens as $token) {
            if (is_string($token)) {
                $result .= $token;
                continue;
            }

            [$id, $text] = $token;

            if ($id === T_COMMENT) {
                if ($this->isLineComment($text)) {
                    continue;
                }

                $result .= $text;
                continue;
            }

            $result .= $text;
        }

        return $result;
    }

    private function isLineComment(string $comment): bool
    {
        return str_starts_with($comment, '//')
            || str_starts_with($comment, '#');
    }
}
