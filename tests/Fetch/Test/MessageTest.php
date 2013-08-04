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

/**
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 * @author  Patrik Karisch <patrik.karisch@abimus.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadMessage()
    {
        $message = $this->getMockBuilder('Fetch\Message')
                        ->disableOriginalConstructor()
                        ->setMethods(array('getOverview', 'getHeaders', 'processAddressObject', 'getStructure', 'processStructure'))
                        ->getMock();

        $message->expects($this->once())
                ->method('getOverview')
                ->will($this->returnValue($this->getOverview()));

        $message->expects($this->once())
                ->method('getHeaders')
                ->will($this->returnValue($this->getHeaders()));

        $method = new \ReflectionMethod($message, 'loadMessage');
        $method->setAccessible(true);
        $method->invoke($message);

        $this->assertEquals('Test', $message->getSubject());
        $this->assertTrue($message->checkFlag('recent'));
    }

    /**
     * from Github Issue #21
     *
     * @dataProvider invalidOverviews
     */
    public function testLoadMessageWithInvalidOverviews($overview)
    {
        $message = $this->getMockBuilder('Fetch\Message')
                        ->disableOriginalConstructor()
                        ->setMethods(array('getOverview', 'getHeaders', 'processAddressObject', 'getStructure', 'processStructure'))
                        ->getMock();

        $message->expects($this->once())
                ->method('getOverview')
                ->will($this->returnValue($overview));

        $message->expects($this->once())
                ->method('getHeaders')
                ->will($this->returnValue($this->getHeaders()));

        $method = new \ReflectionMethod($message, 'loadMessage');
        $method->setAccessible(true);
        $method->invoke($message);
    }

    protected function getOverview()
    {
        $overview = new \stdClass();
        $overview->subject = 'Test';
        $overview->date = new \DateTime();
        $overview->date = $overview->date->format('c');
        $overview->size = 12345;
        $overview->recent = 1;
        $overview->flagged = 0;
        $overview->answered = 0;
        $overview->deleted = 0;
        $overview->seen = 0;
        $overview->draft = 0;

        return $overview;
    }

    public function invalidOverviews()
    {
        $data = array();
        $fields = array('subject', 'date', 'size', 'recent', 'flagged', 'answered', 'deleted', 'seen', 'draft');

        foreach ($fields as $field) {
            $overview = $this->getOverview();
            unset($overview->$field);

            $data[] = array($overview);
        }

        return $data;
    }

    protected function getHeaders()
    {
        $headers = new \stdClass();
        $headers->from = array((object) array('mailbox' => 'foo', 'host' => 'example.com'));

        return $headers;
    }
}
