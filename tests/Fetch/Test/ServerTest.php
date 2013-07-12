<?php

/*
 * This file is part of the Fetch library.
 *
 * (c) Robert Hafner <tedivm@tedivm.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fetch\Test;

use Fetch\Server;

/**
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 */
class ServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider flagsDataProvider
     * @param string $expected server string with %host% placeholder
     * @param integer $port to use (needed to test behavior on port 143 and 993 from constructor)
     * @param array $flags to set/unset ($flag => $value)
     */
    public function testFlags($expected, $port, $flags)
    {
        $host = 'example.com';
        $server = new Server($host, $port);
    
        foreach ($flags as $flag => $value) {
            $server->setFlag($flag, $value);
        }
    
        $this->assertEquals(str_replace('%host%', $host, $expected), $server->getServerString());
    }
    
    public function flagsDataProvider() {
        return array(
                array('{%host%:143/novalidate-cert}', 143, array()),
                array('{%host%:143/validate-cert}', 143, array('validate-cert' => true)),
                array('{%host%:143}', 143, array('novalidate-cert' => false)),
                array('{%host%:993/ssl}', 993, array()),
                array('{%host%:993}', 993, array('ssl' => false)),
                array('{%host%:100/tls}', 100, array('tls' => true)),
                array('{%host%:100/tls}', 100, array('tls' => true, 'tls' => true)),
                array('{%host%:100/notls}', 100, array('tls' => true, 'notls' => true)),
                array('{%host%:100}', 100, array('ssl' => true, 'ssl' => false)),
                array('{%host%:100/user=foo}', 100, array('user' => 'foo')),
                array('{%host%:100/user=foo}', 100, array('user' => 'foo', 'user' => 'foo')),
                array('{%host%:100/user=bar}', 100, array('user' => 'foo', 'user' => 'bar')),
                array('{%host%:100}', 100, array('user' => 'foo', 'user' => false)),
        );
    }
}
