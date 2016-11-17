<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequest;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Exceptions\HttpRequestException;

final class ConcreteControllerHttpRequestTest extends \PHPUnit_Framework_TestCase {
    private $commandMock;
    private $viewMock;
    private $valueMock;
    private $queryParameters;
    private $requestParameters;
    private $headers;
    public function setUp() {
        $this->commandMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Command');
        $this->viewMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Views\View');
        $this->valueMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Values\Value');

        $this->queryParameters = [
            'some' => $this->valueMock,
            'another' => $this->valueMock
        ];

        $this->requestParameters = [
            'request' => $this->valueMock,
            'just' => $this->valueMock
        ];

        $this->headers = [
            'Authentication' => $this->valueMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $httpRequest = new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock);

        $this->assertEquals($this->commandMock, $httpRequest->getCommand());
        $this->assertEquals($this->viewMock, $httpRequest->getView());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());

    }

    public function testCreate_withQueryParameters_Success() {

        $httpRequest = new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, $this->queryParameters);

        $this->assertEquals($this->commandMock, $httpRequest->getCommand());
        $this->assertEquals($this->viewMock, $httpRequest->getView());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());

    }

    public function testCreate_withRequestParameters_Success() {

        $httpRequest = new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, null, $this->requestParameters);

        $this->assertEquals($this->commandMock, $httpRequest->getCommand());
        $this->assertEquals($this->viewMock, $httpRequest->getView());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());

    }

    public function testCreate_withHeaders_Success() {

        $httpRequest = new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, null, null, $this->headers);

        $this->assertEquals($this->commandMock, $httpRequest->getCommand());
        $this->assertEquals($this->viewMock, $httpRequest->getView());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasHeaders());
        $this->assertEquals($this->headers, $httpRequest->getHeaders());

    }

    public function testCreate_withQueryParameters_withRequestParameters_withHeaders_Success() {

        $httpRequest = new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, $this->queryParameters, $this->requestParameters, $this->headers);

        $this->assertEquals($this->commandMock, $httpRequest->getCommand());
        $this->assertEquals($this->viewMock, $httpRequest->getView());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasHeaders());
        $this->assertEquals($this->headers, $httpRequest->getHeaders());

    }

    public function testCreate_withQueryParameters_withOneInvalidQueryParameterKeyname_throwsHttpRequestException() {

        $this->queryParameters[] = $this->valueMock;

        $asserted = false;
        try {

            new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, $this->queryParameters);

        } catch (HttpRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withQueryParameters_withOneInvalidQueryParameterValue_throwsHttpRequestException() {

        $this->queryParameters['voila'] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, $this->queryParameters);

        } catch (HttpRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withRequestParameters_withOneInvalidRequestParameterKeyname_throwsHttpRequestException() {

        $this->requestParameters[] = $this->valueMock;

        $asserted = false;
        try {

            new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, null, $this->requestParameters);

        } catch (HttpRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withRequestParameters_withOneInvalidRequestParameterValue_throwsHttpRequestException() {

        $this->requestParameters['voila'] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, null, $this->requestParameters);

        } catch (HttpRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withHeaders_withOneInvalidHeaderKeyname_throwsHttpRequestException() {

        $this->headers[] = $this->valueMock;

        $asserted = false;
        try {

            new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, null, null, $this->headers);

        } catch (HttpRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withHeaders_withOneInvalidHeaderValue_throwsHttpRequestException() {

        $this->headers['voila'] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteControllerHttpRequest($this->commandMock, $this->viewMock, null, null, $this->headers);

        } catch (HttpRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
