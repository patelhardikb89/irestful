<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Factories\CurlHttpApplicationFactory;

final class CurlHttpApplicationFactoryTest extends \PHPUnit_Framework_TestCase {
    private $baseUrl;
    private $factory;
    public function setUp() {
        $this->baseUrl = 'http://apis.https.irestful.dev';
        $this->factory = new CurlHttpApplicationFactory($this->baseUrl);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $httpApplication = $this->factory->create();

        $this->assertTrue($httpApplication instanceof \iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication);

    }

}
