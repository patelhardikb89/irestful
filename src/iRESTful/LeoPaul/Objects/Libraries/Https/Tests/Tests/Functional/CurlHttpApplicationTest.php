<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Functional;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Applications\CurlHttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters\HttpRequestAdapterHelper;

final class CurlHttpApplicationTest extends \PHPUnit_Framework_TestCase {
    private $httpRequestAdapterMock;
	private $httpRequestMock;
    private $request;
	private $baseUrl;
    private $invalidBaseUrl;
	private $uri;
	private $method;
	private $port;
	private $nonDefaultPort;
	private $queryParameters;
	private $requestParameters;
	private $headers;
	private $filePath;
	private $outputHeaders;
	private $outputHeadersWithNonDefaultPort;
	private $requestOutputHeaders;
	private $authOutputHeaders;
	private $fileOutputHeaders;
	private $application;
    private $applicationWithInvalidBaseUrl;
    private $httpRequestAdapterHelper;
	private $httpRequestHelper;
	public function setUp() {

        $this->httpRequestAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter');
		$this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');

        $this->request = [
            'some' => 'request data'
        ];

		$this->baseUrl = 'http://apis.https.irestful.dev';
        $this->invalidBaseUrl = 'http://invalid.base.url';
		$this->uri = '/index.php';
		$this->method = 'post';
		$this->port = 80;
		$this->nonDefaultPort = 123;
		$this->queryParameters = [
			'slug' => 'my_slug'
		];

		$this->requestParameters = [
			'my' => 'param',
			'another' => 'param2',
			'param' => null
		];

		$this->headers = [
			'Authorization' => 'iRESTful key'
		];

		$this->filePath = __FILE__;

		$this->outputHeaders = [
			'Host' => 'apis.https.irestful.dev',
			'Accept' => '*/*'
		];

		$this->outputHeadersWithNonDefaultPort = [
			'Host' => 'apis.https.irestful.dev:123',
			'Accept' => '*/*'
		];

		$this->requestOutputHeaders = [
			'Host' => 'apis.https.irestful.dev',
			'Accept' => '*/*',
			'Content-Length' => 30,
			'Content-Type' => 'application/x-www-form-urlencoded'
		];

		$this->authOutputHeaders = [
			'Host' => 'apis.https.irestful.dev',
			'Accept' => '*/*',
			'Authorization' => $this->headers['Authorization']
		];

		$this->fileOutputHeaders = [
			'Host' => 'apis.https.irestful.dev',
			'Accept' => '*/*',
			'Expect' => '100-continue'
		];

		$this->application = new CurlHttpApplication($this->httpRequestAdapterMock, $this->baseUrl);
        $this->applicationWithInvalidBaseUrl = new CurlHttpApplication($this->httpRequestAdapterMock, $this->invalidBaseUrl);

        $this->httpRequestAdapterHelper = new HttpRequestAdapterHelper($this, $this->httpRequestAdapterMock);
		$this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
	}

	public function tearDown() {

	}

	public function testExecute_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

		$this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->port);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(false);
		$this->httpRequestHelper->expectsHasRequestParameters_Success(false);
		$this->httpRequestHelper->expectsHasHeaders_Success(false);
		$this->httpRequestHelper->expectsHasFilePath_Success(false);

		$response = $this->application->execute($this->request);

		$this->assertEquals(200, $response->getCode());
		$this->assertEquals('no params', $response->getContent());
		$this->assertEquals($this->outputHeaders, $response->getHeaders());

	}

	public function testExecute_withNonDefaultPort_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

		$this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->nonDefaultPort);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(false);
		$this->httpRequestHelper->expectsHasRequestParameters_Success(false);
		$this->httpRequestHelper->expectsHasHeaders_Success(false);
		$this->httpRequestHelper->expectsHasFilePath_Success(false);

		$response = $this->application->execute($this->request);

		$this->assertEquals(200, $response->getCode());
		$this->assertEquals('non default port!', $response->getContent());
		$this->assertEquals($this->outputHeadersWithNonDefaultPort, $response->getHeaders());

	}

	public function testExecute_withQueryParameters_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

		$this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->port);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(true);
		$this->httpRequestHelper->expectsGetQueryParameters_Success($this->queryParameters);

		$this->httpRequestHelper->expectsHasRequestParameters_Success(false);
		$this->httpRequestHelper->expectsHasHeaders_Success(false);
		$this->httpRequestHelper->expectsHasFilePath_Success(false);

		$response = $this->application->execute($this->request);

		$this->assertEquals(200, $response->getCode());
		$this->assertEquals(json_encode($this->queryParameters), $response->getContent());
		$this->assertEquals($this->outputHeaders, $response->getHeaders());

	}

	public function testExecute_withRequestParameters_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

		$this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->port);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(false);

		$this->httpRequestHelper->expectsHasRequestParameters_Success(true);
		$this->httpRequestHelper->expectsGetRequestParameters_Success($this->requestParameters);

		$this->httpRequestHelper->expectsHasHeaders_Success(false);
		$this->httpRequestHelper->expectsHasFilePath_Success(false);

		$response = $this->application->execute($this->request);

		$this->assertEquals(200, $response->getCode());
		$this->assertEquals(json_encode($this->requestParameters), $response->getContent());
		$this->assertEquals($this->requestOutputHeaders, $response->getHeaders());

	}

	public function testExecute_withHeaders_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

		$this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->port);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(false);
		$this->httpRequestHelper->expectsHasRequestParameters_Success(false);

		$this->httpRequestHelper->expectsHasHeaders_Success(true);
		$this->httpRequestHelper->expectsGetHeaders_Success($this->headers);

		$this->httpRequestHelper->expectsHasFilePath_Success(false);

		$response = $this->application->execute($this->request);

		$this->assertEquals(200, $response->getCode());
		$this->assertEquals('Authorization -> '.$this->headers['Authorization'], $response->getContent());
		$this->assertEquals($this->authOutputHeaders, $response->getHeaders());

	}

	public function testExecute_withFilePath_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

		$this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->port);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(false);
		$this->httpRequestHelper->expectsHasRequestParameters_Success(false);
		$this->httpRequestHelper->expectsHasHeaders_Success(false);

		$this->httpRequestHelper->expectsHasFilePath_Success(true);
		$this->httpRequestHelper->expectsGetFilePath_Success($this->filePath);

		$response = $this->application->execute($this->request);
		$outputHeaders = $response->getHeaders();

		$this->assertEquals(200, $response->getCode());
		$this->assertEquals('file size -> '.filesize($this->filePath), $response->getContent());
		$this->assertEquals($this->fileOutputHeaders['Host'], $outputHeaders['Host']);
		$this->assertEquals($this->fileOutputHeaders['Accept'], $outputHeaders['Accept']);
		$this->assertEquals($this->fileOutputHeaders['Expect'], $outputHeaders['Expect']);
		$this->assertTrue(isset($outputHeaders['Content-Type']) && !empty($outputHeaders['Content-Type']));
		$this->assertTrue(isset($outputHeaders['Content-Length']) && !empty($outputHeaders['Content-Length']));

	}

    public function testExecute_withInvalidBaseUrl_throwsHttpException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
		$this->httpRequestHelper->expectsGetMethod_Success($this->method);
		$this->httpRequestHelper->expectsGetPort_Success($this->port);

		$this->httpRequestHelper->expectsHasQueryParameters_Success(false);
		$this->httpRequestHelper->expectsHasRequestParameters_Success(false);
		$this->httpRequestHelper->expectsHasHeaders_Success(false);
		$this->httpRequestHelper->expectsHasFilePath_Success(false);

        $asserted = false;
        try {

            $this->applicationWithInvalidBaseUrl->execute($this->request);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

	}

    public function testExecute_withInvalidRequestData_throwsHttpException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_throwsHttpException($this->request);

        $asserted = false;
        try {

            $this->applicationWithInvalidBaseUrl->execute($this->request);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

	}
}
