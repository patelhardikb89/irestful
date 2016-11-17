<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Repositories\PDORepositoryHelper;

final class PDORepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoRepositoryMock;
    private $pdoMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->pdoRepositoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');

        $this->data = [
            'query' => 'select * from my_table;'
        ];

        $this->helper = new PDORepositoryHelper($this, $this->pdoRepositoryMock );
    }

    public function tearDown() {

    }

    public function testFetch_Success() {

        $this->helper->expectsFetch_Success($this->pdoMock, $this->data);

        $pdo = $this->pdoRepositoryMock->fetch($this->data);

        $this->assertEquals($this->pdoMock, $pdo);

    }

    public function testFetch_throwsPDOException() {

        $this->helper->expectsFetch_throwsPDOException($this->data);

        $asserted = true;
        try {

            $this->pdoRepositoryMock->fetch($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFetchFirst_Success() {

        $this->helper->expectsFetchFirst_Success($this->pdoMock, $this->data);

        $pdo = $this->pdoRepositoryMock->fetchFirst($this->data);

        $this->assertEquals($this->pdoMock, $pdo);

    }

    public function testFetchFirst_throwsPDOException() {

        $this->helper->expectsFetchFirst_throwsPDOException($this->data);

        $asserted = true;
        try {

            $this->pdoRepositoryMock->fetchFirst($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
