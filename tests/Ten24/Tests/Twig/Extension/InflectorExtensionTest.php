<?php

namespace Ten24\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Ten24\Twig\Extension\InflectorExtension;

/**
 * Class InflectorExtensionTest
 *
 * @package Ten24\Tests\Twig\Extension
 */
class InflectorExtensionTest extends TestCase
{
    /** @var InflectorExtension */
    protected $ex;

    public function setUp()
    {
        $this->ex = new InflectorExtension();
    }

    public function testCamelCaseToCapitalizedWords()
    {
        $res      = $this->ex->camelCaseToCapitalizedWords('camelCasedStringWith1Number');
        $expected = 'Camel Cased String With 1 Number';

        self::assertEquals($expected, $res);
    }

    public function testCamelCaseToSentenceCasedWords()
    {
        $res      = $this->ex->camelCaseToSentenceCasedWords('camelCasedStringWith1Number');
        $expected = 'Camel cased string with 1 number';

        self::assertEquals($expected, $res);
    }
}