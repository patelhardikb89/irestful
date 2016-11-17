<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications\HttpApplicationHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpApplicationHelperTest extends \PHPUnit_Framework_TestCase {
    private $httpApplicationMock;
    private $httpResponseMock;
    private $request;
    private $helper;
    public function setUp() {
        $this->httpApplicationMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication');
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');

        $this->request = [
            'some' => 'request data'
        ];

        $this->helper = new HttpApplicationHelper($this, $this->httpApplicationMock);
    }

    public function tearDown() {

    }

    public function testExecute_Success() {

        $this->helper->expectsExecute_Success($this->httpResponseMock, $this->request);

        $response = $this->httpApplicationMock->execute($this->request);

        $this->assertEquals($this->httpResponseMock, $response);

    }

    public function testExecute_throwsHttpException() {

        $this->helper->expectsExecute_throwsHttpException($this->request);

        $asserted = false;
        try {

            $this->httpApplicationMock->execute($this->request);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
