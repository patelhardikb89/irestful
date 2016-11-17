<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpResponseHelper;

final class HttpResponseHelperTest extends \PHPUnit_Framework_TestCase {
    private $httpResponseMock;
    private $code;
    private $content;
    private $headers;
    private $helper;
    public function setUp() {
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');

        $this->code = 200;
        $this->content = 'some content';
        $this->headers = [
            'some' => 'content'
        ];

        $this->helper = new HttpResponseHelper($this, $this->httpResponseMock);
    }

    public function tearDown() {

    }

    public function testGetCode_Success() {

        $this->helper->expectsGetCode_Success($this->code);

        $code = $this->httpResponseMock->getCode();

        $this->assertEquals($this->code, $code);

    }

    public function testGetContent_Success() {

        $this->helper->expectsGetContent_Success($this->content);

        $content = $this->httpResponseMock->getContent();

        $this->assertEquals($this->content, $content);

    }

    public function testHasHeaders_Success() {

        $this->helper->expectsHasHeaders_Success(false);

        $hasHeaders = $this->httpResponseMock->hasHeaders();

        $this->assertFalse($hasHeaders);

    }

    public function testGetHeaders_Success() {

        $this->helper->expectsGetHeaders_Success($this->headers);

        $headers = $this->httpResponseMock->getHeaders();

        $this->assertEquals($this->headers, $headers);

    }

}
