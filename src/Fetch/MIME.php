<?php

/*
 * This file is part of the Fetch package.
 *
 * (c) Robert Hafner <tedivm@tedivm.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fetch;

/**
 * This library is a wrapper around the Imap library functions included in php.
 *
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 * @author  Sergey Linnik <linniksa@gmail.com>
 */
final class MIME
{
    /**
     * @param string $text
     * @param string $targetCharset
     *
     * @return string
     */
    public static function decode($text, $targetCharset = 'utf-8')
    {
        if (null === $text) {
            return null;
        }

        $result = '';

        foreach (imap_mime_header_decode($text) as $word) {
            $ch = 'default' === $word->charset ? 'ascii' : $word->charset;
            $text = $word->text;
            // Use the possible false return of `mb_encoding_aliases()` to detect whether we can process the encoding
            if (function_exists('mb_convert_encoding') && @mb_encoding_aliases($ch)) {
                // This will strip any unrecognised characters and ensure we avoid
                // "Detected an incomplete multibyte character in input string" errors
                $text = mb_convert_encoding($text, $ch, $ch);
            }

            $result .= iconv($ch, $targetCharset, $text);
        }

        return $result;
    }
}
