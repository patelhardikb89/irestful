<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObject;
use iRESTful\Rodson\Domain\Objects\Exceptions\ObjectException;

final class ConcreteObjectTest extends \PHPUnit_Framework_TestCase {
    private $propertyMock;
    private $databaseMock;
    private $name;
    private $properties;
    public function setUp() {
        $this->propertyMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Properties\Property');
        $this->databaseMock = $this->getMock('iRESTful\Rodson\Domain\Databases\Database');

        $this->name = 'MyObject';
        $this->properties = [
            $this->propertyMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $object = new ConcreteObject($this->name, $this->properties);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertFalse($object->hasDatabase());
        $this->assertNull($object->getDatabase());

    }

    public function testCreate_withDatabase_Success() {

        $object = new ConcreteObject($this->name, $this->properties, $this->databaseMock);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertTrue($object->hasDatabase());
        $this->assertEquals($this->databaseMock, $object->getDatabase());

    }

    public function testCreate_withInvalidIndexInProperties_throwsObjectException() {

        $asserted = false;
        try {

            new ConcreteObject($this->name, ['some' => $this->propertyMock]);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidProperty_throwsObjectException() {

        $this->properties[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteObject($this->name, $this->properties);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutProperties_throwsObjectException() {

        $asserted = false;
        try {

            new ConcreteObject($this->name, []);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsObjectException() {

        $asserted = false;
        try {

            new ConcreteObject('', $this->properties);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsObjectException() {

        $asserted = false;
        try {

            new ConcreteObject(new \DateTime(), $this->properties);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
