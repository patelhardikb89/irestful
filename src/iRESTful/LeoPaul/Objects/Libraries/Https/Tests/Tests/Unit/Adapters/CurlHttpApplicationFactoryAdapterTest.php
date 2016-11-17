<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class CurlHttpApplicationFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $adapter;
    public function setUp() {
        $this->data = [
            'base_url' => 'http://apis.https.irestful.dev'
        ];
        $this->adapter = new CurlHttpApplicationFactoryAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToHttpApplicationFactory_Success() {

        $httpApplicationFactory = $this->adapter->fromDataToHttpApplicationFactory($this->data);

        $this->assertTrue($httpApplicationFactory instanceof \iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\HttpApplicationFactory);

    }

    public function testFromDataToHttpApplicationFactory_withoutBaseUrl_throwsHttpException() {

        unset($this->data['base_url']);

        $asserted = false;
        try {

            $this->adapter->fromDataToHttpApplicationFactory($this->data);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
