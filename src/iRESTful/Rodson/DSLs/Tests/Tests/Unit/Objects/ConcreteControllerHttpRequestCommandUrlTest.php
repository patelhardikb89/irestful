<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestCommandUrl;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Exceptions\UrlException;

final class ConcreteControllerHttpRequestCommandUrlTest extends \PHPUnit_Framework_TestCase {
    private $urlMock;
    private $endpoint;
    private $port;
    public function setUp() {
        $this->urlMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\URLs\Url');
        $this->endpoint = '/my/endpoint';
        $this->port = rand(1, 500);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $url = new ConcreteControllerHttpRequestCommandUrl($this->urlMock, $this->endpoint);

        $this->assertEquals($this->urlMock, $url->getBaseUrl());
        $this->assertEquals($this->endpoint, $url->getEndpoint());
        $this->assertFalse($url->hasPort());
        $this->assertNull($url->getPort());

    }

    public function testCreate_withPort_Success() {

        $url = new ConcreteControllerHttpRequestCommandUrl($this->urlMock, $this->endpoint, $this->port);

        $this->assertEquals($this->urlMock, $url->getBaseUrl());
        $this->assertEquals($this->endpoint, $url->getEndpoint());
        $this->assertTrue($url->hasPort());
        $this->assertEquals($this->port, $url->getPort());

    }

    public function testCreate_withZeroPort_Success() {

        $url = new ConcreteControllerHttpRequestCommandUrl($this->urlMock, $this->endpoint, 0);

        $this->assertEquals($this->urlMock, $url->getBaseUrl());
        $this->assertEquals($this->endpoint, $url->getEndpoint());
        $this->assertFalse($url->hasPort());
        $this->assertNull($url->getPort());

    }

    public function testCreate_withoutBeginningSlashOnEndpoint_throwsUrlException() {

        $asserted = false;
        try {

            new ConcreteControllerHttpRequestCommandUrl($this->urlMock, 'some/endpoint');

        } catch (UrlException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTrailingSlashOnEndpoint_throwsUrlException() {

        $asserted = false;
        try {

            new ConcreteControllerHttpRequestCommandUrl($this->urlMock, '/some/endpoint/');

        } catch (UrlException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyEndpoint_throwsUrlException() {

        $asserted = false;
        try {

            new ConcreteControllerHttpRequestCommandUrl($this->urlMock, '');

        } catch (UrlException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
