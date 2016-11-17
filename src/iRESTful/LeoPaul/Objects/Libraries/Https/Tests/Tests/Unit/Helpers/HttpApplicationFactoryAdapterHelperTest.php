<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters\HttpApplicationFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpApplicationFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $httpApplicationFactoryAdapterMock;
    private $httpApplicationFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->httpApplicationFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter');
        $this->httpApplicationFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\HttpApplicationFactory');

        $this->data = [
            'base_url' => 'http://apis.https.irestful.dev'
        ];

        $this->helper = new HttpApplicationFactoryAdapterHelper($this, $this->httpApplicationFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToHttpApplicationFactory_Success() {

        $this->helper->expectsFromDataToHttpApplicationFactory_Success($this->httpApplicationFactoryMock, $this->data);

        $factory = $this->httpApplicationFactoryAdapterMock->fromDataToHttpApplicationFactory($this->data);

        $this->assertEquals($this->httpApplicationFactoryMock, $factory);

    }

    public function testFromDataToHttpApplicationFactory_throwsHttpException() {

        $this->helper->expectsFromDataToHttpApplicationFactory_throwsHttpException($this->data);

        $asserted = false;
        try {

            $this->httpApplicationFactoryAdapterMock->fromDataToHttpApplicationFactory($this->data);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
