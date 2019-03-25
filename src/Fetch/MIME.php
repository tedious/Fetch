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

        $encoding = mb_detect_encoding($text, mb_detect_order(), false);

        if($encoding == "UTF-8") {
            $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        }

        $result = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);

        return $result;
    }
}
