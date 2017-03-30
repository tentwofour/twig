<?php

namespace Ten24\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Ten24\Twig\Extension\MoneyExtension;

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

        self::assertInternalType('string', $res);
        self::assertEquals(12.00, $res);
    }

    public function testDollarsToCents()
    {
        $res = $this->ex->centsToDollarsLocalized(1200);

        self::assertInternalType('string', $res);
        self::assertEquals('12.00', $res);
    }
}