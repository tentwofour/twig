<?php

namespace Ten24\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Ten24\Twig\Extension\DiffExtension;

/**
 * Class DiffExtensionTest
 *
 * @package Ten24\Tests\Twig\Extension
 */
class DiffExtensionTest extends TestCase
{
    /** @var DiffExtension */
    protected $ex;

    public function setUp()
    {
        $this->ex = new DiffExtension();
    }

    public function testThatDiffWithNonArrayArgumentsAreCastToArray()
    {
        $res = $this->ex->diff('valueA', 'valueB');

        $expected = [
            0 =>
                [
                    'd' => [
                        0 => 'valueA',
                    ],
                    'i' => [
                        0 => 'valueB',
                    ],
                ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testDiffWithNumericalArguments()
    {
        $a   = [
            'key' => 1,
        ];
        $b   = [
            'key' => 10,
        ];
        $res = $this->ex->diff($a, $b);

        self::assertInternalType('int', $res[0]['d']['key']);
        self::assertInternalType('int', $res[0]['i']['key']);
    }

    public function testDiffWithStringArguments()
    {
        $a   = [
            'key' => 'value',
        ];
        $b   = [
            'key' => 'value_2',
        ];
        $res = $this->ex->diff($a, $b);

        self::assertInternalType('string', $res[0]['d']['key']);
        self::assertInternalType('string', $res[0]['i']['key']);
    }

    public function testSingleDimensionDiffWithSingleChange()
    {
        $a        = [
            'key' => 'value',
        ];
        $b        = [
            'key' => 'value_2',
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0 => [
                'd' => [
                    'key' => 'value',
                ],
                'i' => [
                    'key' => 'value_2',
                ],
            ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testSingleDimensionDiffWithMultipleChanges()
    {
        $a        = [
            'key'   => 'value',
            'key_2' => 'value',
        ];
        $b        = [
            'key'   => 'value_2',
            'key_2' => 'value_2',
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0 => [
                'd' => [
                    'key'   => 'value',
                    'key_2' => 'value',
                ],
                'i' => [
                    'key'   => 'value_2',
                    'key_2' => 'value_2',
                ],
            ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testSingleDimensionDiffWithAddition()
    {
        $a        = [
            'key' => 'value',
        ];
        $b        = [
            'key'   => 'value_2',
            'key_2' => 'value_2',
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0 => [
                'd' => [
                    'key' => 'value',
                ],
                'i' => [
                    'key'   => 'value_2',
                    'key_2' => 'value_2',
                ],
            ],
        ];
        var_dump($res);

        self::assertEquals($expected, $res);
    }

    public function testSingleDimensionDiffWithRemoval()
    {
        $a        = [
            'key'   => 'value',
            'key_2' => 'value_2',
            'key_3' => 'value_3',
        ];
        $b        = [
            'key'   => 'value',
            'key_2' => 'value_2',
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0       =>
                [
                    'd' => [],
                    'i' => [],
                ],
            'key'   => 'value',
            1       =>
                [
                    'd' => [],
                    'i' => [],
                ],
            'key_2' => 'value_2',
            2       => [
                'd' => [
                    'key_3' => 'value_3',
                ],
                'i' => [],
            ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testMultiDimensionDiffWithSingleChange()
    {
        $a        = [
            'key' => [
                'sub_key' => 'sub_value',
            ],
        ];
        $b        = [
            'key' => [
                'sub_key' => 'sub_value_2',
            ],
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0 => [
                'd' => [
                    'key' => [
                        'sub_key' => 'sub_value',
                    ],
                ],

                'i' => [
                    'key' => [
                        'sub_key' => 'sub_value_2',
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testMultiDimensionDiffWithMultipleChanges()
    {
        $a        = [
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_3' => [
                        'sub_sub_sub_value_1',
                    ],
                ],
            ],
            'key_2' => 'value',
        ];
        $b        = [
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_3' => [
                        'sub_sub_sub_value_1',
                    ],
                ],
            ],
            'key_2' => 'value',
            'key_3' => [
                'sub_key_3_1' => 'sub_value_3_1',
            ],
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0       => [
                'd' => [],
                'i' => [],
            ],
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_3' => [
                        0 => 'sub_sub_sub_value_1',
                    ],
                ],
            ],
            1       => [
                'd' => [],
                'i' => [],
            ],
            'key_2' => 'value',
            2       => [
                'd' => [],
                'i' => [
                    'key_3' => [
                        'sub_key_3_1' => 'sub_value_3_1',
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testMultiDimensionDiffWithAddition()
    {
        $this->ex = new DiffExtension();
        $a        = [
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_1' => 'sub_sub_value_1',
                ],
            ],
            'key_2' => 'value',
        ];
        $b        = [
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_1' => 'sub_sub_value_1',
                    'sub_sub_key_2' => 'sub_sub_value_2',
                ],
                'sub_key_3' => 'sub_value_3',
            ],
            'key_2' => 'value',
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0       => [
                'd' => [],
                'i' => [],
            ],
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_1' => 'sub_sub_value_1',
                    'sub_sub_key_2' => 'sub_sub_value_2',
                ],
                'sub_key_3' => 'sub_value_3',
            ],
            1       =>
                [
                    'd' => [],
                    'i' => [],
                ],
            'key_2' => 'value',
            2       =>
                [
                    'd' => [],
                    'i' => [],
                ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testMultiDimensionDiffWithRemoval()
    {
        $a        = [
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_1' => 'sub_sub_value_1',
                    'sub_sub_key_2' => 'sub_sub_value_2',
                ],
                'sub_key_3' => 'sub_value_3',
            ],
            'key_2' => 'value',
        ];
        $b        = [
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' => [
                    'sub_sub_key_1' => 'sub_sub_value_1',
                ],
            ],
            'key_2' => 'value',
        ];
        $res      = $this->ex->diff($a, $b);
        $expected = [
            0       =>
                [
                    'd' => [],
                    'i' => [],
                ],
            'key'   => [
                'sub_key_1' => 'sub_value_1',
                'sub_key_2' =>
                    [
                        'sub_sub_key_1' => 'sub_sub_value_1',
                    ],
            ],
            1       => [
                'd' => [],
                'i' => [],
            ],
            'key_2' => 'value',
            2       => [
                'd' => [],
                'i' => [],
            ],
        ];

        self::assertEquals($expected, $res);
    }

    public function testHtmlDiffWithUnknownOutputTypeThrowsException()
    {

        self::expectExceptionMessage('Unknown output type "integer"');
        self::expectException(\RuntimeException::class);

        $this->ex->diffHtml('a', 'b', 'integer'); // WTF is wrong with you?
    }

    public function testHtmlDiffWithDefaultOutput()
    {
        $this->testHtmlDiffAsArrayOutput();
    }

    public function testHtmlDiffAsArrayOutput()
    {
        $old      = 'The lazy fox was eaten by the rabbid rabbit.';
        $new      = 'The stupid lazy fox was annihilated by the rabbit rabbit!';
        $res      = $this->ex->diffHtml($old, $new, 'array');
        $expected = [
            'old' => 'The lazy fox was <del>eaten</del> by the <del>rabbid rabbit.</del>',
            'new' => 'The <ins>stupid</ins> lazy fox was <ins>annihilated</ins> by the <ins>rabbit rabbit!</ins>',
        ];

        self::assertEquals($expected, $res);
    }

    public function testHtmlDiffAsStringOutput()
    {
        $old      = 'The lazy fox was eaten by the rabbid rabbit.';
        $new      = 'The stupid lazy fox was annihilated by the rabbit rabbit!';
        $res      = $this->ex->diffHtml($old, $new, 'string');
        $expected = 'The <ins>stupid</ins> lazy fox was <del>eaten</del><ins>annihilated</ins> by the <del>rabbid rabbit.</del><ins>rabbit rabbit!</ins>';

        self::assertEquals($expected, $res);
    }
}