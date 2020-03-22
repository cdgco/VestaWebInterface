<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests;

use PhpMyAdmin\MoTranslator\Translator;
use PHPUnit\Framework\TestCase;

/**
 * Test for gettext parsing.
 */
class PluralTest extends TestCase
{
    /**
     * Test for npgettext.
     *
     * @param int    $number   Number
     * @param string $expected Expected output
     *
     * @dataProvider providerTestNpgettext
     */
    public function testNpgettext($number, $expected)
    {
        $parser = new Translator('');
        $result = $parser->npgettext(
            'context',
            "%d pig went to the market\n",
            "%d pigs went to the market\n",
            $number
        );
        $this->assertSame($expected, $result);
    }

    /**
     * Data provider for test_npgettext.
     *
     * @return array
     */
    public static function providerTestNpgettext()
    {
        return [
            [
                1,
                "%d pig went to the market\n",
            ],
            [
                2,
                "%d pigs went to the market\n",
            ],
        ];
    }
}
