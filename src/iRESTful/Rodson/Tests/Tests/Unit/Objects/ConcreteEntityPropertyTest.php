<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteEntityProperty;
use iRESTful\Rodson\Domain\Entities\Properties\Exceptions\PropertyException;

final class ConcreteEntityPropertyTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $name;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Types\Type');

        $this->name = 'my_property';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $property = new ConcreteEntityProperty($this->name, $this->typeMock);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());

    }

    public function testCreate_withCamelCaseName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteEntityProperty('myProperty', $this->typeMock);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteEntityProperty('', $this->typeMock);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteEntityProperty(new \DateTime(), $this->typeMock);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
