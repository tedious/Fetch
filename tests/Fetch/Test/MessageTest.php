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

    }

    public function testGetHeaders()
    {

    }

    public function testGetStructure()
    {

    }

    public function testGetMessageBody()
    {

    }

    public function testGetAddresses()
    {

    }

    public function testGetDate()
    {

    }

    public function testGetSubject()
    {

    }

    public function testDelete()
    {

    }

    public function testGetImapBox()
    {

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

    }

    public function testSetFlag()
    {

    }

    public function testMoveToMailbox()
    {

    }


    public function testDecode()
    {

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
