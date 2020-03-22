<?php
/*
    Copyright (c) 2003, 2009 Danilo Segan <danilo@kvota.net>.
    Copyright (c) 2005 Nico Kaiser <nico@siriux.net>
    Copyright (c) 2016 Michal Čihař <michal@cihar.com>

    This file is part of MoTranslator.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Throwable;
use function array_key_exists;
use function chr;
use function count;
use function explode;
use function implode;
use function intval;
use function is_readable;
use function ltrim;
use function preg_replace;
use function rtrim;
use function strcmp;
use function stripos;
use function strpos;
use function strtolower;
use function substr;
use function trim;

/**
 * Provides a simple gettext replacement that works independently from
 * the system's gettext abilities.
 * It can read MO files and use them for translating strings.
 *
 * It caches ll strings and translations to speed up the string lookup.
 */
class Translator
{
    /**
     * None error.
     */
    public const ERROR_NONE = 0;
    /**
     * File does not exist.
     */
    public const ERROR_DOES_NOT_EXIST = 1;
    /**
     * File has bad magic number.
     */
    public const ERROR_BAD_MAGIC = 2;
    /**
     * Error while reading file, probably too short.
     */
    public const ERROR_READING = 3;

    /**
     * Big endian mo file magic bytes.
     */
    public const MAGIC_BE = "\x95\x04\x12\xde";
    /**
     * Little endian mo file magic bytes.
     */
    public const MAGIC_LE = "\xde\x12\x04\x95";

    /**
     * Parse error code (0 if no error).
     *
     * @var int
     */
    public $error = self::ERROR_NONE;

    /**
     * Cache header field for plural forms.
     *
     * @var string|null
     */
    private $pluralEquation = null;

    /** @var ExpressionLanguage|null Evaluator for plurals */
    private $pluralExpression = null;

    /** @var int|null number of plurals */
    private $pluralCount = null;

    /**
     * Array with original -> translation mapping.
     *
     * @var array
     */
    private $cacheTranslations = [];

    /**
     * @param string $filename Name of mo file to load
     */
    public function __construct(string $filename)
    {
        if (! is_readable($filename)) {
            $this->error = self::ERROR_DOES_NOT_EXIST;

            return;
        }

        $stream = new StringReader($filename);

        try {
            $magic = $stream->read(0, 4);
            if (strcmp($magic, self::MAGIC_LE) === 0) {
                $unpack = 'V';
            } elseif (strcmp($magic, self::MAGIC_BE) === 0) {
                $unpack = 'N';
            } else {
                $this->error = self::ERROR_BAD_MAGIC;

                return;
            }

            /* Parse header */
            $total = $stream->readint($unpack, 8);
            $originals = $stream->readint($unpack, 12);
            $translations = $stream->readint($unpack, 16);

            /* get original and translations tables */
            $tableOriginals = $stream->readintarray($unpack, $originals, $total * 2);
            $tableTranslations = $stream->readintarray($unpack, $translations, $total * 2);

            /* read all strings to the cache */
            for ($i = 0; $i < $total; ++$i) {
                $original = $stream->read($tableOriginals[$i * 2 + 2], $tableOriginals[$i * 2 + 1]);
                $translation = $stream->read($tableTranslations[$i * 2 + 2], $tableTranslations[$i * 2 + 1]);
                $this->cacheTranslations[$original] = $translation;
            }
        } catch (ReaderException $e) {
            $this->error = self::ERROR_READING;

            return;
        }
    }

    /**
     * Translates a string.
     *
     * @param string $msgid String to be translated
     *
     * @return string translated string (or original, if not found)
     */
    public function gettext($msgid)
    {
        if (array_key_exists($msgid, $this->cacheTranslations)) {
            return $this->cacheTranslations[$msgid];
        }

        return $msgid;
    }

    /**
     * Check if a string is translated.
     *
     * @param string $msgid String to be checked
     *
     * @return bool
     */
    public function exists($msgid)
    {
        return array_key_exists($msgid, $this->cacheTranslations);
    }

    /**
     * Sanitize plural form expression for use in ExpressionLanguage.
     *
     * @param string $expr Expression to sanitize
     *
     * @return string sanitized plural form expression
     */
    public static function sanitizePluralExpression($expr)
    {
        // Parse equation
        $expr = explode(';', $expr);
        if (count($expr) >= 2) {
            $expr = $expr[1];
        } else {
            $expr = $expr[0];
        }

        $expr = trim(strtolower($expr));
        // Strip plural prefix
        if (substr($expr, 0, 6) === 'plural') {
            $expr = ltrim(substr($expr, 6));
        }

        // Strip equals
        if (substr($expr, 0, 1) === '=') {
            $expr = ltrim(substr($expr, 1));
        }

        // Cleanup from unwanted chars
        $expr = preg_replace('@[^n0-9:\(\)\?=!<>/%&| ]@', '', $expr);

        return (string) $expr;
    }

    /**
     * Extracts number of plurals from plurals form expression.
     *
     * @param string $expr Expression to process
     *
     * @return int Total number of plurals
     */
    public static function extractPluralCount($expr)
    {
        $parts = explode(';', $expr, 2);
        $nplurals = explode('=', trim($parts[0]), 2);
        if (strtolower(rtrim($nplurals[0])) !== 'nplurals') {
            return 1;
        }

        if (count($nplurals) === 1) {
            return 1;
        }

        return intval($nplurals[1]);
    }

    /**
     * Parse full PO header and extract only plural forms line.
     *
     * @param string $header Gettext header
     *
     * @return string verbatim plural form header field
     */
    public static function extractPluralsForms($header)
    {
        $headers = explode("\n", $header);
        $expr = 'nplurals=2; plural=n == 1 ? 0 : 1;';
        foreach ($headers as $header) {
            if (stripos($header, 'Plural-Forms:') !== 0) {
                continue;
            }

            $expr = substr($header, 13);
        }

        return $expr;
    }

    /**
     * Get possible plural forms from MO header.
     *
     * @return string plural form header
     */
    private function getPluralForms()
    {
        // lets assume message number 0 is header
        // this is true, right?

        // cache header field for plural forms
        if ($this->pluralEquation === null) {
            if (isset($this->cacheTranslations[''])) {
                $header = $this->cacheTranslations[''];
            } else {
                $header = '';
            }

            $expr = $this->extractPluralsForms($header);
            $this->pluralEquation = $this->sanitizePluralExpression($expr);
            $this->pluralCount = $this->extractPluralCount($expr);
        }

        return $this->pluralEquation;
    }

    /**
     * Detects which plural form to take.
     *
     * @param int $n count of objects
     *
     * @return int array index of the right plural form
     */
    private function selectString($n)
    {
        if ($this->pluralExpression === null) {
            $this->pluralExpression = new ExpressionLanguage();
        }

        try {
            $plural = $this->pluralExpression->evaluate(
                $this->getPluralForms(),
                ['n' => $n]
            );
        } catch (Throwable $e) {
            $plural = 0;
        }

        if ($plural >= $this->pluralCount) {
            $plural = $this->pluralCount - 1;
        }

        return $plural;
    }

    /**
     * Plural version of gettext.
     *
     * @param string $msgid       Single form
     * @param string $msgidPlural Plural form
     * @param int    $number      Number of objects
     *
     * @return string translated plural form
     */
    public function ngettext($msgid, $msgidPlural, $number)
    {
        // this should contains all strings separated by NULLs
        $key = implode(chr(0), [$msgid, $msgidPlural]);
        if (! array_key_exists($key, $this->cacheTranslations)) {
            return $number !== 1 ? $msgidPlural : $msgid;
        }

        // find out the appropriate form
        $select = $this->selectString($number);

        $result = $this->cacheTranslations[$key];
        $list = explode(chr(0), $result);
        if ($list === false) {
            return '';
        }

        if (! isset($list[$select])) {
            return $list[0];
        }

        return $list[$select];
    }

    /**
     * Translate with context.
     *
     * @param string $msgctxt Context
     * @param string $msgid   String to be translated
     *
     * @return string translated plural form
     */
    public function pgettext($msgctxt, $msgid)
    {
        $key = implode(chr(4), [$msgctxt, $msgid]);
        $ret = $this->gettext($key);
        if (strpos($ret, chr(4)) !== false) {
            return $msgid;
        }

        return $ret;
    }

    /**
     * Plural version of pgettext.
     *
     * @param string $msgctxt     Context
     * @param string $msgid       Single form
     * @param string $msgidPlural Plural form
     * @param int    $number      Number of objects
     *
     * @return string translated plural form
     */
    public function npgettext($msgctxt, $msgid, $msgidPlural, $number)
    {
        $key = implode(chr(4), [$msgctxt, $msgid]);
        $ret = $this->ngettext($key, $msgidPlural, $number);
        if (strpos($ret, chr(4)) !== false) {
            return $msgid;
        }

        return $ret;
    }

    /**
     * Set translation in place
     *
     * @param string $msgid  String to be set
     * @param string $msgstr Translation
     *
     * @return void
     */
    public function setTranslation($msgid, $msgstr)
    {
        $this->cacheTranslations[$msgid] = $msgstr;
    }
}
