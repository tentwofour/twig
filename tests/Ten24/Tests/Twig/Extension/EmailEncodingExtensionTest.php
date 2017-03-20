<?php

namespace Ten24\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Ten24\Twig\Extension\EmailEncodingExtension;

/**
 * Class EmailEncodingExtensionTest
 *
 * @package Ten24\Tests\Twig\Extension
 */
class EmailEncodingExtensionTest extends TestCase
{
    /** @var EmailEncodingExtension */
    protected $ex;

    public function setUp()
    {
        $this->ex = new EmailEncodingExtension();
    }

    public function testFilter()
    {
        $email     = 'f@example.com';
        $filtered  = $this->ex->filter($email);
        $decrypted = '';
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