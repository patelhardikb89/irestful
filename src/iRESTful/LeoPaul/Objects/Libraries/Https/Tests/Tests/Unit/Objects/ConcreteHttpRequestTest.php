<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects\ConcreteHttpRequest;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRequestTest extends \PHPUnit_Framework_TestCase {
    private $uri;
    private $httpMethod;
    private $port;
    private $queryParameters;
    private $requestParameters;
    private $headers;
    private $filePath;
    public function setUp() {

        $this->uri = '/some/uri';
        $this->httpMethod = 'get';
        $this->port = rand(1, 500);
        $this->queryParameters = array(
            'first' => 'parameter',
            'second' => 'element'
        );

        $this->requestParameters = array(
            'uuid' => 'some uuid',
            'title' => 'This is some title'
        );

        $this->headers = [
            'Date' => 'Fri, 14 Sep 2012 21:51:17 GMT',
            'Server' => 'Apache/2.2.3 (CentOS)'
        ];

        $this->filePath = __FILE__;

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasParameters());
        $this->assertNull($httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withUppercaseHttpMethod_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, strtoupper($this->httpMethod), $this->port);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasParameters());
        $this->assertNull($httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withEmptyQueryParameters_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, array());

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasParameters());
        $this->assertNull($httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withEmptyRequestParameters_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, null, array());

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertFalse($httpRequest->hasParameters());
        $this->assertNull($httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withQueryParameters_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, $this->queryParameters);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertFalse($httpRequest->hasRequestParameters());
        $this->assertNull($httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withRequestParameters_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, null, $this->requestParameters);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertFalse($httpRequest->hasQueryParameters());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withQueryParameters_withRequestParameters_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, $this->queryParameters, $this->requestParameters);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasParameters());
        $this->assertEquals(array_merge($this->queryParameters, $this->requestParameters), $httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withQueryParameters_withRequestParameters_withEmptyHeaders_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, $this->queryParameters, $this->requestParameters, []);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasParameters());
        $this->assertEquals(array_merge($this->queryParameters, $this->requestParameters), $httpRequest->getParameters());
        $this->assertFalse($httpRequest->hasHeaders());
        $this->assertNull($httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withQueryParameters_withRequestParameters_withHeaders_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, $this->queryParameters, $this->requestParameters, $this->headers);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasParameters());
        $this->assertEquals(array_merge($this->queryParameters, $this->requestParameters), $httpRequest->getParameters());
        $this->assertTrue($httpRequest->hasHeaders());
        $this->assertEquals($this->headers, $httpRequest->getHeaders());
        $this->assertFalse($httpRequest->hasFilePath());
        $this->assertNull($httpRequest->getFilePath());

    }

    public function testCreate_withQueryParameters_withRequestParameters_withHeaders_withFilePath_Success() {

        $httpRequest = new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, $this->queryParameters, $this->requestParameters, $this->headers, $this->filePath);

        $this->assertEquals($this->uri, $httpRequest->getURI());
        $this->assertEquals($this->httpMethod, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertTrue($httpRequest->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertTrue($httpRequest->hasRequestParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());
        $this->assertTrue($httpRequest->hasParameters());
        $this->assertEquals(array_merge($this->queryParameters, $this->requestParameters), $httpRequest->getParameters());
        $this->assertTrue($httpRequest->hasHeaders());
        $this->assertEquals($this->headers, $httpRequest->getHeaders());
        $this->assertTrue($httpRequest->hasFilePath());
        $this->assertEquals($this->filePath, $httpRequest->getFilePath());

    }

    public function testCreate_withInvalidURI_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpRequest(32, $this->httpMethod, $this->port);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidHttpMethod_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpRequest($this->uri, 'invalid http method', $this->port);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidPort_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpRequest($this->uri, $this->httpMethod, 'invalid port');

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidFilePath_throwsHttpException() {

        $asserted = false;
        try {

            new ConcreteHttpRequest($this->uri, $this->httpMethod, $this->port, $this->queryParameters, $this->requestParameters, $this->headers, __DIR__.'/invalid.file');

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testProcess_withOneSubPattern_Success() {

        $uriPattern = '/$[a-z]+|container$/bulk';
        $outputQueryParameters = [
            'container' => 'roger'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port);
        $this->assertNull($httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withQueryParameters_withOneSubPattern_Success() {

        $uriPattern = '/$[a-z]+|container$/bulk';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $outputQueryParameters = [
            'one' => 'parameter',
            'container' => 'roger'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withTwoSubPattern_Success() {

        $uriPattern = '/$[a-z]+|container$/$[a-z]+|section$';
        $outputQueryParameters = [
            'container' => 'roger',
            'section' => 'bulk'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port);
        $this->assertNull($httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withQueryParameters_withTwoSubPattern_Success() {

        $uriPattern = '/$[a-z]+|container$/$[a-z]+|section$';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $outputQueryParameters = [
            'one' => 'parameter',
            'container' => 'roger',
            'section' => 'bulk'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withTwoSubPattern_lastOneIsJustVariable_Success() {

        $uriPattern = '/$[a-z]+|container$/$section$';
        $outputQueryParameters = [
            'container' => 'roger',
            'section' => 'bulk'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port);
        $this->assertNull($httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withQueryParameters_withTwoSubPattern_lastOneIsJustVariable_Success() {

        $uriPattern = '/$[a-z]+|container$/$section$';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $outputQueryParameters = [
            'one' => 'parameter',
            'container' => 'roger',
            'section' => 'bulk'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withTwoSubPattern_firstOneIsTwoCharacter_lastOneIsJustVariable_Success() {

        $uriPattern = '/$[a-z]{2}|container$ger/$section$';
        $outputQueryParameters = [
            'container' => 'ro',
            'section' => 'bulk'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port);
        $this->assertNull($httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withQueryParameters_firstOneIsTwoCharacter_withTwoSubPattern_lastOneIsJustVariable_Success() {

        $uriPattern = '/$[a-z]{2}|container$ger/$section$';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $outputQueryParameters = [
            'one' => 'parameter',
            'container' => 'ro',
            'section' => 'bulk'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($outputQueryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withTwoSubPattern_firstOneIsTwoCharacter_doesNotMatch_Success() {

        $uriPattern = '/$[a-z]{2}|container$/$section$';
        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port);
        $this->assertNull($httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertNull($httpRequest->getQueryParameters());

    }

    public function testProcess_withQueryParameters_firstOneIsTwoCharacter_withTwoSubPattern_doesNotMatch_Success() {

        $uriPattern = '/$[a-z]{2}|container$/$section$';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withExactMatch_Success() {

        $uriPattern = '/roger/bulk';
        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port);
        $this->assertNull($httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertNull($httpRequest->getQueryParameters());

    }

    public function testProcess_withQueryParameters_withExactMatch_Success() {

        $uriPattern = '/roger/bulk';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_withTwoVariables_firstOneIsSyntaxInvalid_Success() {

        $uriPattern = '/$[a-z]{2}|container|invalid$/$section$';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

    }

    public function testProcess_patternsDoesNotMatch_Success() {

        $uriPattern = '/$[0-9]+|container/$[0-9]+|section$';
        $queryParameters = [
            'one' => 'parameter'
        ];

        $httpRequest = new ConcreteHttpRequest('/roger/bulk', $this->httpMethod, $this->port, $queryParameters);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

        $httpRequest = $httpRequest->process($uriPattern);
        $this->assertEquals($queryParameters, $httpRequest->getQueryParameters());

    }

}
