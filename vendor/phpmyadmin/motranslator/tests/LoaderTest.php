<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */

use PHPUnit\Framework\TestCase;

/**
 * Test for mo loading.
 */
class LoaderTest extends TestCase
{
    /**
     * @dataProvider localeList
     *
     * @param mixed $locale
     * @param mixed $expected
     */
    public function testListLocales($locale, $expected)
    {
        $this->assertEquals(
            $expected,
            PhpMyAdmin\MoTranslator\Loader::listLocales($locale)
        );
    }

    public function localeList()
    {
        return array(
            array(
                'cs_CZ',
                array('cs_CZ', 'cs'),
            ),
            array(
                'sr_CS.UTF-8@latin',
                array(
                    'sr_CS.UTF-8@latin',
                    'sr_CS@latin',
                    'sr@latin',
                    'sr_CS.UTF-8',
                    'sr_CS',
                    'sr',
                ),
            ),
            // For a locale containing country code, we prefer
            // full locale name, but if that's not found, fall back
            // to the language only locale name.
            array(
                'sr_RS',
                array('sr_RS', 'sr'),
            ),
            // If language code is used, it's the only thing returned.
            array(
                'sr',
                array('sr'),
            ),
            // There is support for language and charset only.
            array(
                'sr.UTF-8',
                array('sr.UTF-8', 'sr'),
            ),

            // It can also split out character set from the full locale name.
            array(
                'sr_RS.UTF-8',
                array('sr_RS.UTF-8', 'sr_RS', 'sr'),
            ),

            // There is support for @modifier in locale names as well.
            array(
                'sr_RS.UTF-8@latin',
                array(
                    'sr_RS.UTF-8@latin', 'sr_RS@latin', 'sr@latin',
                    'sr_RS.UTF-8', 'sr_RS', 'sr',
                ),
            ),
            array(
                'sr.UTF-8@latin',
                array(
                    'sr.UTF-8@latin', 'sr@latin', 'sr.UTF-8', 'sr',
                ),
            ),

            // We can pass in only language and modifier.
            array(
                'sr@latin',
                array('sr@latin', 'sr'),
            ),

            // If locale name is not following the regular POSIX pattern,
            // it's used verbatim.
            array(
                'something',
                array('something'),
            ),

            // Passing in an empty string returns an empty array.
            array(
                '',
                array(),
            ),
        );
    }

    private function getLoader($domain, $locale)
    {
        $loader = new PhpMyAdmin\MoTranslator\Loader();
        $loader->setlocale($locale);
        $loader->textdomain($domain);
        $loader->bindtextdomain($domain, __DIR__ . '/data/locale/');

        return $loader;
    }

    public function testLocaleChange()
    {
        $loader = new PhpMyAdmin\MoTranslator\Loader();
        $loader->setlocale('cs');
        $loader->textdomain('phpmyadmin');
        $loader->bindtextdomain('phpmyadmin', __DIR__ . '/data/locale/');
        $translator = $loader->getTranslator('phpmyadmin');
        $this->assertEquals('Typ', $translator->gettext('Type'));
        $loader->setlocale('be_BY');
        $translator = $loader->getTranslator('phpmyadmin');
        $this->assertEquals('Тып', $translator->gettext('Type'));
    }

    /**
     * @dataProvider translatorData
     *
     * @param mixed $domain
     * @param mixed $locale
     * @param mixed $otherdomain
     * @param mixed $expected
     */
    public function testGetTranslator($domain, $locale, $otherdomain, $expected)
    {
        $loader = $this->getLoader($domain, $locale);
        $translator = $loader->getTranslator($otherdomain);
        $this->assertEquals(
            $expected,
            $translator->gettext('Type')
        );
    }

    public function translatorData()
    {
        return array(
            array(
                'phpmyadmin',
                'cs',
                '',
                'Typ',
            ),
            array(
                'phpmyadmin',
                'cs_CZ',
                '',
                'Typ',
            ),
            array(
                'phpmyadmin',
                'be_BY',
                '',
                'Тып',
            ),
            array(
                'phpmyadmin',
                'be@latin',
                '',
                'Typ',
            ),
            array(
                'phpmyadmin',
                'cs',
                'other',
                'Type',
            ),
            array(
                'other',
                'cs',
                'phpmyadmin',
                'Type',
            ),
        );
    }

    public function testInstance()
    {
        $loader = PhpMyAdmin\MoTranslator\Loader::getInstance();
        $loader->setlocale('cs');
        $loader->textdomain('phpmyadmin');
        $loader->bindtextdomain('phpmyadmin', __DIR__ . '/data/locale/');

        $translator = $loader->getTranslator();
        $this->assertEquals(
            'Typ',
            $translator->gettext('Type')
        );

        /* Ensure the object survives */
        $loader = PhpMyAdmin\MoTranslator\Loader::getInstance();
        $translator = $loader->getTranslator();
        $this->assertEquals(
            'Typ',
            $translator->gettext('Type')
        );

        /* Ensure the object can support different locale files for the same domain */
        $loader = PhpMyAdmin\MoTranslator\Loader::getInstance();
        $loader->setlocale('be_BY');
        $loader->bindtextdomain('phpmyadmin', __DIR__ . '/data/locale/');
        $translator = $loader->getTranslator();
        $this->assertEquals(
            'Тып',
            $translator->gettext('Type')
        );
    }

    public function testDetect()
    {
        $GLOBALS['lang'] = 'foo';
        $loader = PhpMyAdmin\MoTranslator\Loader::getInstance();
        $this->assertEquals(
            'foo',
            $loader->detectlocale()
        );
        unset($GLOBALS['lang']);
    }

    public function testDetectEnv()
    {
        $loader = PhpMyAdmin\MoTranslator\Loader::getInstance();
        // putenv/getenv is broken on hhvm, do not fight with it
        foreach (array('LC_MESSAGES', 'LC_ALL', 'LANG') as $var) {
            putenv($var . '=baz');
            if (getenv($var) !== 'baz') {
                $this->markTestSkipped('Setting environment does not work');
            }
            putenv($var);
            if (getenv($var) !== false) {
                $this->markTestSkipped('Unsetting environment does not work');
            }
        }

        unset($GLOBALS['lang']);
        putenv('LC_ALL=baz');
        $this->assertEquals(
            'baz',
            $loader->detectlocale()
        );
        putenv('LC_ALL');
        putenv('LC_MESSAGES=bar');
        $this->assertEquals(
            'bar',
            $loader->detectlocale()
        );
        putenv('LC_MESSAGES');
        putenv('LANG=barr');
        $this->assertEquals(
            'barr',
            $loader->detectlocale()
        );
        putenv('LANG');
        $this->assertEquals(
            'en',
            $loader->detectlocale()
        );
    }
}
