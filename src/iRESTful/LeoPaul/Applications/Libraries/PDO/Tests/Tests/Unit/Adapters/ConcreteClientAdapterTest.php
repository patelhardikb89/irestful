<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Objects\TestPDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteClientAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions\ClientException;

final class ConcreteClientAdapterTest extends \PHPUnit_Framework_TestCase {
    private $pdo;
    private $pdoThrowsException;
    private $version;
    private $connectedBy;
    private $adapter;
    public function setUp() {
        $this->pdo = new TestPDO();
        $this->pdoThrowsException = new TestPDO(true);
        $this->version = 'v1.2.3';
        $this->connectedBy = '127.0.0.1 by TCP/IP';

        $this->adapter = new ConcreteClientAdapter();
    }

    public function tearDown() {

    }

    public function testFromNativePDOToClient_Success() {
        $client = $this->adapter->fromNativePDOToClient($this->pdo);

        $this->assertEquals($this->version, $client->getVersion());
        $this->assertEquals($this->connectedBy, $client->connectedBy());
    }

    public function testFromNativePDOToClient_throwsPDOException_throwsClientException() {

        $asserted = false;
        try {

            $this->adapter->fromNativePDOToClient($this->pdoThrowsException);

        } catch (ClientException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
