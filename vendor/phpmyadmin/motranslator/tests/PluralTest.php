<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */

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
     *
     * @dataProvider providerTestNpgettext
     */
    public function testNpgettext($number, $expected)
    {
        $parser = new PhpMyAdmin\MoTranslator\Translator(null);
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
        return array(
            array(1, "%d pig went to the market\n"),
            array(2, "%d pigs went to the market\n"),
        );
    }
}
