<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters\PDOServiceFactoryAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOServiceFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoServiceFactoryAdapterMock;
    private $pdoServiceFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->pdoServiceFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\Adapters\PDOServiceFactoryAdapter');
        $this->pdoServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\PDOServiceFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new PDOServiceFactoryAdapterHelper($this, $this->pdoServiceFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToPDOServiceFactory_Success() {

        $this->helper->expectsFromDataToPDOServiceFactory_Success($this->pdoServiceFactoryMock, $this->data);

        $factory = $this->pdoServiceFactoryAdapterMock->fromDataToPDOServiceFactory($this->data);

        $this->assertEquals($this->pdoServiceFactoryMock, $factory);

    }

    public function testFromDataToPDOServiceFactory_throwsPDOException() {

        $this->helper->expectsFromDataToPDOServiceFactory_throwsPDOException($this->data);

        $asserted = false;
        try {

            $this->pdoServiceFactoryAdapterMock->fromDataToPDOServiceFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
