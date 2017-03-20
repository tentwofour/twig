<?php

namespace Ten24\Twig\Extension;

/**
 * Class EmailEncodingExtension
 *
 * @package Ten24\Twig\Extension
 */
class EmailEncodingExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'email_encode' => new \Twig_Filter_Method($this, 'filter', array(
                'is_safe' => array('html'))),
        );
    }

    public function filter($text)
    {
        return $this->encodeText($text);
    }

    /**
     * Thanks to SF 1.2 UrlHelper.php
     * @param $text
     * @return string
     */
    protected function encodeText($text)
    {
        $encoded_text = '';

        for ($i = 0; $i < strlen($text); $i++)
        {
            $char = $text{$i};
            $r = rand(0, 100);

            # roughly 10% raw, 45% hex, 45% dec
            # '@' *must* be encoded. I insist.
            if ($r > 90 && $char != '@')
            {
                $encoded_text .= $char;
            }
            else if ($r < 45)
            {
                $encoded_text .= '&#x' . dechex(ord($char)) . ';';
            }
            else
            {
                $encoded_text .= '&#' . ord($char) . ';';
            }
        }

        return $encoded_text;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'ten24_twig.email_encoding';
    }
}