<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters\PDOAdapterFactoryAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOAdapterFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoAdapterFactoryAdapterMock;
    private $pdoAdapterFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->pdoAdapterFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\Factories\Adapters\PDOAdapterFactoryAdapter');
        $this->pdoAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\Factories\PDOAdapterFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new PDOAdapterFactoryAdapterHelper($this, $this->pdoAdapterFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToPDOAdapterFactory_Success() {

        $this->helper->expectsFromDataToPDOAdapterFactory_Success($this->pdoAdapterFactoryMock, $this->data);

        $factory = $this->pdoAdapterFactoryAdapterMock->fromDataToPDOAdapterFactory($this->data);

        $this->assertEquals($this->pdoAdapterFactoryMock, $factory);

    }

    public function testFromDataToPDOAdapterFactory_throwsPDOException() {

        $this->helper->expectsFromDataToPDOAdapterFactory_throwsPDOException($this->data);

        $asserted = false;
        try {

            $this->pdoAdapterFactoryAdapterMock->fromDataToPDOAdapterFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
