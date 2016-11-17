<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects\ConcreteHttpResponse;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpResponseTest extends \PHPUnit_Framework_TestCase {
    private $code;
    private $content;
    private $headers;
    public function setUp() {

        $this->code = 200;
        $this->content = 'some content';
        $this->headers = [
            'Date' => 'Fri, 14 Sep 2012 21:51:17 GMT',
            'Server' => 'Apache/2.2.3 (CentOS)'
        ];

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $response = new ConcreteHttpResponse($this->code, $this->content);

        $this->assertEquals($this->code, $response->getCode());
        $this->assertEquals($this->content, $response->getContent());
        $this->assertFalse($response->hasHeaders());
        $this->assertNull($response->getHeaders());

    }

    public function testCreate_withHeaders_Success() {

        $response = new ConcreteHttpResponse($this->code, $this->content, $this->headers);

        $this->assertEquals($this->code, $response->getCode());
        $this->assertEquals($this->content, $response->getContent());
        $this->assertTrue($response->hasHeaders());
        $this->assertEquals($this->headers, $response->getHeaders());

    }

    public function testCreate_withEmptyContent_Success() {

        $response = new ConcreteHttpResponse($this->code, '');

        $this->assertEquals($this->code, $response->getCode());
        $this->assertEquals('', $response->getContent());
        $this->assertFalse($response->hasHeaders());
        $this->assertNull($response->getHeaders());

    }

    public function testCreate_withInvalidCode_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpResponse('invalid code', $this->content);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroCode_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpResponse(0, $this->content);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeCode_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpResponse(-1, $this->content);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidContent_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpResponse($this->code, rand(0, 500));

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
