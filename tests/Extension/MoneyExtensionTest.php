<?php

namespace Ten24\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Ten24\Twig\Extension\MoneyExtension;
use TypeError;

/**
 * Class MoneyExtensionTest
 *
 * @package Ten24\Tests\Twig\Extension
 */
class MoneyExtensionTest extends TestCase
{
    /** @var MoneyExtension */
    protected $ex;

    public function setUp()
    {
        $this->ex = new MoneyExtension();
    }

    public function testCentsToDollars()
    {
        $res = $this->ex->centsToDollars(1200);
        self::assertInternalType('float', $res);
        self::assertEquals(12.00, $res);

        $res = $this->ex->centsToDollars(1200.00);
        self::assertInternalType('float', $res);
        self::assertEquals(12.00, $res);

        self::expectException(TypeError::class);
        $res = $this->ex->dollarsToCents('string');
    }

    public function testDollarsToCents()
    {
        $res = $this->ex->dollarsToCents(12.00);
        self::assertInternalType('int', $res);
        self::assertEquals('1200', $res);

        $res = $this->ex->dollarsToCents(12000);
        self::assertInternalType('int', $res);
        self::assertEquals('1200000', $res);

        self::expectException(TypeError::class);
        $res = $this->ex->dollarsToCents('string');
    }

    public function testCentsToDollarsLocalized()
    {
        $res = $this->ex->centsToDollarsLocalized(1200, 'cad');

        self::assertInternalType('string', $res);
        self::assertEquals('12.00', $res);


        $res = $this->ex->centsToDollarsLocalized(1200, 'usd');

        self::assertInternalType('string', $res);
        self::assertEquals('12.00', $res);

    }
}