<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteClient;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions\ClientException;

final class ConcreteClientTest extends \PHPUnit_Framework_TestCase {
    private $version;
    private $connectedBy;
    public function setUp() {
        $this->version = '13.22.13';
        $this->connectedBy = '127.0.0.1 by TCP/IP';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $client = new ConcreteClient($this->version, $this->connectedBy);

        $this->assertEquals($this->version, $client->getVersion());
        $this->assertEquals($this->connectedBy, $client->connectedBy());

    }

    public function testCreate_withEmptyConnectedBy_Success() {

        $asserted = false;
        try {

            new ConcreteClient($this->version, '');

        } catch (ClientException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringConnectedBy_Success() {

        $asserted = false;
        try {

            new ConcreteClient($this->version, new \DateTime());

        } catch (ClientException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyVersion_Success() {

        $asserted = false;
        try {

            new ConcreteClient('', $this->connectedBy);

        } catch (ClientException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringVersion_Success() {

        $asserted = false;
        try {

            new ConcreteClient(new \DateTime(), $this->connectedBy);

        } catch (ClientException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
