<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteForeignKey;

final class ConcreteForeignKeyTest extends \PHPUnit_Framework_TestCase {
    private $tableMock;
    public function setUp() {
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $foreignKey = new ConcreteForeignKey($this->tableMock);

        $this->assertEquals($this->tableMock, $foreignKey->getTableReference());

    }

}
