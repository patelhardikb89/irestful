<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters\PDORepositoryFactoryAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDORepositoryFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoRepositoryFactoryAdapterMock;
    private $pdoRepositoryFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->pdoRepositoryFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\Adapters\PDORepositoryFactoryAdapter');
        $this->pdoRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\PDORepositoryFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new PDORepositoryFactoryAdapterHelper($this, $this->pdoRepositoryFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToPDORepositoryFactory_Success() {

        $this->helper->expectsFromDataToPDORepositoryFactory_Success($this->pdoRepositoryFactoryMock, $this->data);

        $factory = $this->pdoRepositoryFactoryAdapterMock->fromDataToPDORepositoryFactory($this->data);

        $this->assertEquals($this->pdoRepositoryFactoryMock, $factory);

    }

    public function testFromDataToPDORepositoryFactory_throwsPDOException() {

        $this->helper->expectsFromDataToPDORepositoryFactory_throwsPDOException($this->data);

        $asserted = false;
        try {

            $this->pdoRepositoryFactoryAdapterMock->fromDataToPDORepositoryFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
