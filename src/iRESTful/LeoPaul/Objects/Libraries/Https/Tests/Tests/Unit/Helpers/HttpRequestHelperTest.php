<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class HttpRequestHelperTest extends \PHPUnit_Framework_TestCase {
    private $httpRequestMock;
    private $uriPattern;
    private $parameters;
    private $httpRequestHelper;
    public function setUp() {
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');

        $this->uriPattern = '/$container$/$[a-z]+|name$';
        $this->parameters = [
            'some' => 'params'
        ];

        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
    }

    public function tearDown() {

    }

    public function testHasParameters_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);

        $hasParams = $this->httpRequestMock->hasParameters();

        $this->assertTrue($hasParams);

    }

    public function testGetParameters_Success() {

        $this->httpRequestHelper->expectsGetParameters_Success($this->parameters);

        $params = $this->httpRequestMock->getParameters();

        $this->assertEquals($this->parameters, $params);

    }

    public function testProcess_Success() {

        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $httpRequest = $this->httpRequestMock->process($this->uriPattern);

        $this->assertEquals($this->httpRequestMock, $httpRequest);

    }

}
