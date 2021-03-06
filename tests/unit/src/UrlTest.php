<?php

use G4\Gateway\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $paramsMock;

    /**
     * @var Url
     */
    private $url;

    protected function setUp()
    {
        $this->paramsMock = $this->getMockBuilder('\G4\Gateway\Params')
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = new Url('http://google.com', 'service', $this->paramsMock);
    }

    protected function tearDown()
    {
        $this->paramsMock = null;
        $this->url = null;
    }

    public function testGetUri()
    {
        $this->assertEquals('http://google.com/service', $this->url->getUri());
    }

    public function testGetUriWithoutServiceName()
    {
        $url = new Url('http://google.com', null, $this->paramsMock);
        $this->assertEquals('http://google.com', $url->getUri());
    }

    public function testToString()
    {
        $this->paramsMock
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('id=123');

        $this->assertEquals('http://google.com/service?id=123', (string) $this->url);
    }

    public function testToStringWithoutParams()
    {
        $this->paramsMock
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('');

        $this->assertEquals('http://google.com/service', (string) $this->url);
    }

    public function testGetParams()
    {
        $this->assertEquals($this->paramsMock, $this->url->getParams());
    }

    public function testIfUriIsNotAString()
    {
        $this->setExpectedException('\Exception', 'Uri is not a string!', 101);

        new Url(123, null, $this->paramsMock);
    }
}