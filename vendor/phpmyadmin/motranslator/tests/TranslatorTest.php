<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests;

use PhpMyAdmin\MoTranslator\Translator;
use PHPUnit\Framework\TestCase;

/**
 * Test for translator API
 */
class TranslatorTest extends TestCase
{
    /**
     * Test on empty gettext
     *
     * @return void
     */
    public function testGettext()
    {
        $translator = new Translator('');
        $this->assertEquals('Test', $translator->gettext('Test'));
    }

    /**
     * Test on empty gettext
     *
     * @return void
     */
    public function testSetTranslation()
    {
        $translator = new Translator('');
        $translator->setTranslation('Test', 'Translation');
        $this->assertEquals('Translation', $translator->gettext('Test'));
    }
}
