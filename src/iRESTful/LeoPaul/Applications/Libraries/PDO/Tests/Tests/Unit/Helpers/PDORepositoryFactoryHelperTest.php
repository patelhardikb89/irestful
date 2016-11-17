<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories\PDORepositoryFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDORepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoRepositoryFactoryMock;
    private $pdoRepositoryMock;
    private $helper;
    public function setUp() {
        $this->pdoRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\PDORepositoryFactory');
        $this->pdoRepositoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository');

        $this->helper = new PDORepositoryFactoryHelper($this, $this->pdoRepositoryFactoryMock );
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->pdoRepositoryMock);

        $repository = $this->pdoRepositoryFactoryMock->create();

        $this->assertEquals($this->pdoRepositoryMock, $repository);

    }

    public function testCreate_throwsPDOException() {

        $this->helper->expectsCreate_throwsPDOException();

        $asserted = false;
        try {

            $this->pdoRepositoryFactoryMock->create();

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
