<?php

declare(strict_types=1);

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Output\RenderedContentInterface;

if (! function_exists('convertMarkdownToHtml')) {
    /**
     * Convert Markdown text into html
     *
     * @param array $options
     * @throws CommonMarkException
     */
    function convertMarkdownToHtml(string $markdownContent, array $options = []): RenderedContentInterface
    {
        $converter = new CommonMarkConverter([
            'html_input'         => $options['html_input'] ?? 'strip',
            'allow_unsafe_links' => $options['allow_unsafe_links'] ?? false,
        ]);
        return $converter->convert($markdownContent);
    }
}
