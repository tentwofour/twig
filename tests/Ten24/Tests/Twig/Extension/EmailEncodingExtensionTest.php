<?php

namespace Ten24\Tests\Twig\Extension;

use Ten24\Twig\Extension\EmailEncodingExtension;

class EmailEncodingExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $email     = 'f@example.com';
        $ex        = new EmailEncodingExtension();
        $filtered  = $ex->filter($email);
        $decrypted = '';
echo $filtered;
        preg_match_all('/(?:(?:&#[\w\d]+;)|(?:[\w{1}\d{}1\.]))/im', $filtered, $matches);

        foreach ($matches[0] as $match)
        {
            if (false !== strpos($match, '&#x'))
            {
                $decrypted .= chr(hexdec($match));
                continue;
            }
            elseif(false !== strpos($match, '&#'))
            {
                $decrypted .= chr(str_replace(['&#', ';'], '', $match));
            }
            else
            {
                $decrypted .= $match;
            }
        }

        $this->assertEquals($decrypted, $email);
    }
}