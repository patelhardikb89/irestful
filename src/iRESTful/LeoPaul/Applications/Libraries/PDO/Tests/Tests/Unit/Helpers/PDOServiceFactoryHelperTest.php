<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories\PDOServiceFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOServiceFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoServiceFactoryMock;
    private $pdoServiceMock;
    private $helper;
    public function setUp() {
        $this->pdoServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\PDOServiceFactory');
        $this->pdoServiceMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService');

        $this->helper = new PDOServiceFactoryHelper($this, $this->pdoServiceFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->pdoServiceMock);

        $service = $this->pdoServiceFactoryMock->create();

        $this->assertEquals($this->pdoServiceMock, $service);

    }

    public function testCreate_throwsPDOException() {

        $this->helper->expectsCreate_throwsPDOException();

        $asserted = false;
        try {

            $this->pdoServiceFactoryMock->create();

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
