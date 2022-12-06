<?php

namespace Ten24\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class EmailEncodingExtension
 *
 * @package Ten24\Twig\Extension
 */
class EmailEncodingExtension extends AbstractExtension
{
    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            'email_encode' => new TwigFilter('email_encode', [$this, 'filter'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @param $text
     *
     * @return string
     */
    public function filter($text): string
    {
        return $this->encodeText($text);
    }

    /**
     * Thanks to SF 1.2 UrlHelper.php
     *
     * @param $text
     *
     * @return string
     */
    protected function encodeText($text): string
    {
        $encoded_text = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $r    = rand(0, 100);

            # roughly 10% raw, 45% hex, 45% dec
            # '@' *must* be encoded. I insist.
            if ($r > 90 && $char != '@') {
                $encoded_text .= $char;
            } else if ($r < 45) {
                $encoded_text .= '&#x'.dechex(ord($char)).';';
            } else {
                $encoded_text .= '&#'.ord($char).';';
            }
        }

        return $encoded_text;
    }
}