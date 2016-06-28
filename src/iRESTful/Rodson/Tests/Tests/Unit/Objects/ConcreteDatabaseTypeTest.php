<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteDatabaseType;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseTypeTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $name;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type');

        $this->name = 'string';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $type = new ConcreteDatabaseType($this->name, $this->typeMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->typeMock, $type->getType());

    }

    public function testCreate_withEmptyName_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType('', $this->typeMock);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType(new \DateTime(), $this->typeMock);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
