<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObjectProperty;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectPropertyTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $name;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type');

        $this->name = 'my_property';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, false);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());

    }

    public function testCreate_isOptional_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, true);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertTrue($property->isOptional());

    }

    public function testCreate_withCamelCaseName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty('myProperty', $this->typeMock, true);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty('', $this->typeMock, true);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty(new \DateTime(), $this->typeMock, true);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
