<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Services\PDOServiceHelper;

final class PDOServiceHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoServiceMock;
    private $pdoMock;
    private $data;
    private $multipleData;
    private $helper;
    public function setUp() {
        $this->pdoServiceMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');

        $this->data = [
            'query' => 'insert into mytable (uuid, title) values(:uuid, :title);'
        ];

        $this->multipleData = [
            [
                $this->data
            ],
            [
                'query' => 'insert into myothertable (uuid, title) values(:uuid, :title);'
            ]
        ];

        $this->helper = new PDOServiceHelper($this, $this->pdoServiceMock );
    }

    public function tearDown() {

    }

    public function testQuery_Success() {

        $this->helper->expectsQuery_Success($this->pdoMock, $this->data);

        $pdo = $this->pdoServiceMock->query($this->data);

        $this->assertEquals($this->pdoMock, $pdo);

    }

    public function testQuery_throwsPDOException() {

        $this->helper->expectsQuery_throwsPDOException($this->data);

        $asserted = false;
        try {

            $this->pdoServiceMock->query($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testQueries_Success() {

        $this->helper->expectsQueries_Success($this->pdoMock, $this->multipleData);

        $pdo = $this->pdoServiceMock->queries($this->multipleData);

        $this->assertEquals($this->pdoMock, $pdo);

    }

    public function testQueries_throwsPDOException() {

        $this->helper->expectsQueries_throwsPDOException($this->multipleData);

        $asserted = false;
        try {

            $this->pdoServiceMock->queries($this->multipleData);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
