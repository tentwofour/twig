<?php

namespace Ten24\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Ten24\Twig\Extension\NumberExtension;

/**
 * Class NumberExtensionTest
 *
 * @package Ten24\Tests\Twig\Extension
 */
class NumberExtensionTest extends TestCase
{
    /** @var NumberExtension */
    protected $ex;

    public function setUp()
    {
        $this->ex = new NumberExtension();
    }

    // Millions (M)
    public function testNumberToHumanReadableWithMillionsIntegerAndDefaultArguments()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000);

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    public function testNumberToHumanReadableWithMillionsIntegerAndPrecision()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000, 2);

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    public function testFormatNumberToHumanReadableWithMillionsIntegerAndCeil()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000, 2, 'ceil');

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    public function testFormatNumberToHumanReadableWithMillionsIntegerAndFloor()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000, 2, 'floor');

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }
    
    // thousands (K)
    public function testNumberToHumanReadableWithThousandsIntegerAndDefaultArguments()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000);

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    public function testNumberToHumanReadableWithThousandsIntegerAndPrecision()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000, 2);

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    public function testFormatNumberToHumanReadableWithThousandsIntegerAndCeil()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000, 2, 'ceil');

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    public function testFormatNumberToHumanReadableWithThousandsIntegerAndFloor()
    {
        $res = $this->ex->formatNumberToHumanReadable(120000, 2, 'floor');

        self::assertInternalType('string', $res);
        self::assertEquals('120K', $res);
    }

    // Less than 1000
    public function testNumberToHumanReadableWithIntegerAndDefaultArguments()
    {
        $res = $this->ex->formatNumberToHumanReadable(999);

        self::assertInternalType('string', $res);
        self::assertEquals('999', $res);
    }

    public function testNumberToHumanReadableWithIntegerAndPrecision()
    {
        $res = $this->ex->formatNumberToHumanReadable(999, 2);

        self::assertInternalType('string', $res);
        self::assertEquals('999', $res);
    }

    public function testFormatNumberToHumanReadableWithIntegerAndCeil()
    {
        $res = $this->ex->formatNumberToHumanReadable(999, 2, 'ceil');

        self::assertInternalType('string', $res);
        self::assertEquals('999', $res);
    }

    public function testFormatNumberToHumanReadableWithIntegerAndFloor()
    {
        $res = $this->ex->formatNumberToHumanReadable(999, 2, 'floor');

        self::assertInternalType('string', $res);
        self::assertEquals('999', $res);
    }

    // Decimals >= 1000000
    public function testNumberToHumanReadableWithMillionsDecimalAndDefaultArguments()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154000.14159);

        self::assertInternalType('string', $res);
        self::assertEquals('3M', $res);
    }

    public function testFormatNumberToHumanReadableWithMillionsDecimalAndPrecision()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154000.14159, 2);

        self::assertInternalType('string', $res);
        self::assertEquals('3.15M', $res);
    }

    public function testFormatNumberToHumanReadableWithMillionsDecimalAndCeil()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154000.14159, 2, 'ceil');

        self::assertInternalType('string', $res);
        self::assertEquals('3.16M', $res);
    }

    public function testFormatNumberToHumanReadableWithMillionsDecimalAndFloor()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154000.14159, 2, 'floor');

        self::assertInternalType('string', $res);
        self::assertEquals('3.15M', $res);
    }
    
    // Decimals >= 1000, < 1000000
    public function testNumberToHumanReadableWithThousandsDecimalAndDefaultArguments()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154.14159);

        self::assertInternalType('string', $res);
        self::assertEquals('3K', $res);
    }

    public function testFormatNumberToHumanReadableWithThousandsDecimalAndPrecision()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154.14159, 2);

        self::assertInternalType('string', $res);
        self::assertEquals('3.15K', $res);
    }

    public function testFormatNumberToHumanReadableWithThousandsDecimalAndCeil()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154.14159, 2, 'ceil');

        self::assertInternalType('string', $res);
        self::assertEquals('3.16K', $res);
    }

    public function testFormatNumberToHumanReadableWithThousandsDecimalAndFloor()
    {
        $res = $this->ex->formatNumberToHumanReadable(3154.14159, 2, 'floor');

        self::assertInternalType('string', $res);
        self::assertEquals('3.15K', $res);
    }

    // Decimals < 1000
    public function testNumberToHumanReadableWithDecimalAndDefaultArguments()
    {
        $res = $this->ex->formatNumberToHumanReadable(3.14159);

        self::assertInternalType('string', $res);
        self::assertEquals('3', $res);
    }

    public function testFormatNumberToHumanReadableWithDecimalAndPrecision()
    {
        $res = $this->ex->formatNumberToHumanReadable(3.14159, 2);

        self::assertInternalType('string', $res);
        self::assertEquals('3.14', $res);
    }

    public function testFormatNumberToHumanReadableWithDecimalAndCeil()
    {
        $res = $this->ex->formatNumberToHumanReadable(3.14159, 2, 'ceil');

        self::assertInternalType('string', $res);
        self::assertEquals('3.15', $res);
    }

    public function testFormatNumberToHumanReadableWithDecimalAndFloor()
    {
        $res = $this->ex->formatNumberToHumanReadable(3.14159, 2, 'floor');

        self::assertInternalType('string', $res);
        self::assertEquals('3.14', $res);
    }

    public function testFormatNumberToHumanReadableWithIntegerMinMaxRanges()
    {
        $res = $this->ex->formatNumberToHumanReadable(1);
        self::assertEquals('1', $res);

        $res = $this->ex->formatNumberToHumanReadable(999);
        self::assertEquals('999', $res);

        $res = $this->ex->formatNumberToHumanReadable(999999);
        self::assertEquals('1000K', $res);
    }

    public function testFormatNumberToHumanReadableWithDecimalMinMaxRanges()
    {
        $res = $this->ex->formatNumberToHumanReadable(1.11, 2);
        self::assertEquals('1.11', $res);

        $res = $this->ex->formatNumberToHumanReadable(999.99, 2);
        self::assertEquals('999.99', $res);

        $res = $this->ex->formatNumberToHumanReadable(999999.99, 2);
        self::assertEquals('1000K', $res);
    }

    public function testFormatNumberToHumanReadableWithUnsupportedRoundingMethod()
    {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('The number_to_human_readable filter only supports the "common", "ceil", and "floor" methods.');

        $this->ex->formatNumberToHumanReadable(120000, 4, 'I DO NOT EXIST');
    }

    //Twig_Error_Runtime
}