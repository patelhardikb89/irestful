<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteObject;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;

final class ConcreteObjectTest extends \PHPUnit_Framework_TestCase {
    private $propertyMock;
    private $databaseMock;
    private $methodMock;
    private $sampleMock;
    private $name;
    private $properties;
    private $methods;
    private $samples;
    public function setUp() {
        $this->propertyMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property');
        $this->databaseMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Databases\Database');
        $this->methodMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Method');
        $this->sampleMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Objects\Samples\Sample');

        $this->name = 'MyObject';
        $this->properties = [
            $this->propertyMock,
            $this->propertyMock
        ];

        $this->methods = [
            $this->methodMock,
            $this->methodMock
        ];

        $this->samples = [
            $this->sampleMock,
            $this->sampleMock
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
        $this->assertFalse($object->hasSamples());
        $this->assertNull($object->getSamples());
        $this->assertFalse($object->hasMethods());
        $this->assertNull($object->getMethods());

    }

    public function testCreate_withMethods_Success() {

        $object = new ConcreteObject($this->name, $this->properties, null, $this->methods);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertFalse($object->hasDatabase());
        $this->assertNull($object->getDatabase());
        $this->assertFalse($object->hasSamples());
        $this->assertNull($object->getSamples());
        $this->assertTrue($object->hasMethods());
        $this->assertEquals( $this->methods, $object->getMethods());

    }

    public function testCreate_withDatabase_withSamples_Success() {

        $object = new ConcreteObject($this->name, $this->properties, $this->databaseMock, null, $this->samples);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertTrue($object->hasDatabase());
        $this->assertEquals($this->databaseMock, $object->getDatabase());
        $this->assertTrue($object->hasSamples());
        $this->assertEquals($this->samples, $object->getSamples());
        $this->assertFalse($object->hasMethods());
        $this->assertNull($object->getMethods());

    }

    public function testCreate_withDatabase_withSamples_withMethods_Success() {

        $object = new ConcreteObject($this->name, $this->properties, $this->databaseMock, $this->methods, $this->samples);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertTrue($object->hasDatabase());
        $this->assertEquals($this->databaseMock, $object->getDatabase());
        $this->assertTrue($object->hasSamples());
        $this->assertEquals($this->samples, $object->getSamples());
        $this->assertTrue($object->hasMethods());
        $this->assertEquals( $this->methods, $object->getMethods());

    }

    public function testCreate_withDatabase_withoutSamples_throwsObjectException() {

        $asserted = false;
        try {

            new ConcreteObject($this->name, $this->properties, $this->databaseMock);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutDatabase_withSamples_throwsObjectException() {

        $asserted = false;
        try {

            new ConcreteObject($this->name, $this->properties, null, null, $this->samples);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyProperties_throwsObjectException() {

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

    public function testCreate_withOneInvalidMethod_throwsObjectException() {

        $this->methods[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteObject($this->name, $this->properties, null, $this->methods);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidSample_throwsObjectException() {

        $this->samples[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteObject($this->name, $this->properties, $this->databaseMock, null, $this->samples);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
