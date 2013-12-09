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
use Fetch\Message;


/**
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    public static function getMessage($id)
    {
        $server = ServerTest::getServer();
        return new \Fetch\Message($id, $server);
    }

    public function testConstructMessage()
    {
        $message = static::getMessage(3);
        $this->assertInstanceOf('\Fetch\Message', $message);
    }

    public function testGetOverview()
    {
        $message = static::getMessage(3);
        $overview = $message->getOverview();
        $this->assertEquals('Welcome', $overview->subject, 'Subject');
        $this->assertEquals('tedivm@tedivm.com', $overview->from, 'From');
        $this->assertEquals('testuser@tedivm.com', $overview->to, 'To');
        $this->assertEquals(1465, $overview->size, 'Size');
        $this->assertEquals(0, $overview->flagged, 'Flagged');
        $this->assertEquals(1, $overview->seen, 'Seen');
    }

    public function testGetHeaders()
    {
        $message = static::getMessage(3);
        $headers = $message->getHeaders();
        $this->assertEquals('Sun,  1 Dec 2013 21:14:03 -0800 (PST)', $headers->date, 'Headers contain the right date.');
        $this->assertEquals('testuser@tedivm.com', $headers->toaddress, 'Headers contain toaddress.');
        $this->assertEquals('tedivm@tedivm.com', $headers->fromaddress, 'Headers contain fromaddress');
    }

    public function testGetStructure()
    {

    }

    public function testGetMessageBody()
    {

    }

    public function testGetAddresses()
    {
        $message = static::getMessage(3);

        $addresses = $message->getAddresses('to');
        $this->assertEquals('testuser@tedivm.com', $addresses[0]['address'], 'Retrieving to user from address array.');

        $addressString = $message->getAddresses('to', true);
        $this->assertEquals('testuser@tedivm.com', $addressString, 'Returning To address as string.');

        $addresses = $message->getAddresses('from');
        $this->assertEquals('tedivm@tedivm.com', $addresses['address'], 'Returning From address as an address array.');

        $addressString = $message->getAddresses('from', true);
        $this->assertEquals('tedivm@tedivm.com', $addressString, 'Returning From address as string.');
    }

    public function testGetDate()
    {
        $message = static::getMessage(3);
        $this->assertEquals(1385961243, $message->getDate(), 'Returns date as timestamp.');
    }

    public function testGetSubject()
    {
        $message = static::getMessage(3);
        $this->assertEquals('Welcome', $message->getSubject(), 'Returns Subject.');
    }

    public function testDelete()
    {

    }

    public function testGetImapBox()
    {
        $server = ServerTest::getServer();
        $message = new \Fetch\Message('3', $server);
        $this->assertEquals($server, $message->getImapBox(), 'getImapBox returns Server used to create Message.');
    }

    public function testGetUid()
    {
        $message = static::getMessage('3');
        $this->assertEquals(3, $message->getUid(), 'Message returns UID');
    }

    public function testGetAttachments()
    {
        $messageWithoutAttachments = static::getMessage('3');
        $this->assertFalse($messageWithoutAttachments->getAttachments(), 'getAttachments returns false when no attachments present.');


        $messageWithAttachments = static::getMessage('6');
        $attachments = $messageWithAttachments->getAttachments();
        $this->assertCount(2, $attachments);
        foreach($attachments as $attachment)
            $this->assertInstanceOf('\Fetch\Attachment', $attachment, 'getAttachments returns Fetch\Attachment objects.');
    }

    public function testCheckFlag()
    {
        $message = static::getMessage('3');
        $this->assertFalse($message->checkFlag('flagged'));
        $this->assertTrue($message->checkFlag('seen'));
    }

    public function testSetFlag()
    {
        $message = static::getMessage('3');
        $this->assertFalse($message->checkFlag('answered'), 'Message is not answered.');

        $this->assertTrue($message->setFlag('answered'), 'setFlag returned true.');
        $this->assertTrue($message->checkFlag('answered'), 'Message was successfully answered.');

        $this->assertTrue($message->setFlag('answered', false), 'setFlag returned true.');
        $this->assertFalse($message->checkFlag('answered'), 'Message was successfully unanswered.');


        $message = static::getMessage('2');
        $this->assertFalse($message->checkFlag('flagged'), 'Message is not flagged.');

        $this->assertTrue($message->setFlag('flagged'), 'setFlag returned true.');
        $this->assertTrue($message->checkFlag('flagged'), 'Message was successfully flagged.');

        $message = static::getMessage('2');
        $this->assertTrue($message->setFlag('flagged', false), 'setFlag returned true.');
        $this->assertFalse($message->checkFlag('flagged'), 'Message was successfully unflagged.');
    }

    public function testMoveToMailbox()
    {

    }


    public function testDecode()
    {
        $testString = 'This is a test string';

        $quotedPrintable = quoted_printable_encode($testString);
        $this->assertEquals($testString, Message::decode($quotedPrintable, 'quoted-printable'), 'Decodes quoted printable');

        $base64 = base64_encode($testString);
        $this->assertEquals($testString, Message::decode($base64, 'base64'), 'Decodes quoted base64');
    }

    public function testTypeIdToString()
    {
        $types = array();
        $types[0] = 'text';
        $types[1] = 'multipart';
        $types[2] = 'message';
        $types[3] = 'application';
        $types[4] = 'audio';
        $types[5] = 'image';
        $types[6] = 'video';
        $types[7] = 'other';
        $types[8] = 'other';
        $types[32] = 'other';

        foreach($types as $id => $type)
            $this->assertEquals($type, Message::typeIdToString($id));
    }

    public function testGetParametersFromStructure()
    {

    }


}
