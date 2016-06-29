<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObjectProperty;
use iRESTful\Rodson\Domain\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectPropertyTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $name;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Types\Type');

        $this->name = 'my_property';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());

    }

    public function testCreate_withCamelCaseName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty('myProperty', $this->typeMock);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty('', $this->typeMock);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty(new \DateTime(), $this->typeMock);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
