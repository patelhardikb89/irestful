<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteRodson;
use iRESTful\Rodson\Domain\Exceptions\RodsonException;

final class ConcreteRodsonTest extends \PHPUnit_Framework_TestCase {
    private $rodsonMock;
    private $objectMock;
    private $controllerMock;
    private $name;
    private $parents;
    private $objects;
    private $controllers;
    public function setUp() {
        $this->rodsonMock = $this->getMock('iRESTful\Rodson\Domain\Rodson');
        $this->objectMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Object');
        $this->controllerMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Controllers\Controller');

        $this->name = 'MyProject';

        $this->parents = [
            $this->rodsonMock,
            $this->rodsonMock
        ];

        $this->objects = [
            $this->objectMock,
            $this->objectMock
        ];

        $this->controllers = [
            $this->controllerMock,
            $this->controllerMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $rodson = new ConcreteRodson($this->name, $this->objects, $this->controllers);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertFalse($rodson->hasParents());
        $this->assertNull($rodson->getParents());

    }

    public function testCreate_withParents_Success() {

        $rodson = new ConcreteRodson($this->name, $this->objects, $this->controllers, $this->parents);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertTrue($rodson->hasParents());
        $this->assertEquals($this->parents, $rodson->getParents());

    }

    public function testCreate_withInvalidIndexInObjects_Success() {

        $rodson = new ConcreteRodson($this->name, ['some' => $this->objectMock, 'other' => $this->objectMock], $this->controllers);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertFalse($rodson->hasParents());
        $this->assertNull($rodson->getParents());

    }

    public function testCreate_withInvalidIndexInParents_Success() {

        $rodson = new ConcreteRodson($this->name, $this->objects, $this->controllers, ['some' => $this->rodsonMock, 'other' => $this->rodsonMock]);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertTrue($rodson->hasParents());
        $this->assertEquals($this->parents, $rodson->getParents());

    }

    public function testCreate_withInvalidIndexInControllers_Success() {

        $rodson = new ConcreteRodson($this->name, $this->objects, ['some' => $this->controllerMock, 'other' => $this->controllerMock]);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertFalse($rodson->hasParents());
        $this->assertNull($rodson->getParents());

    }


    public function testCreate_withOneInvalidParent_throwsRodsonException() {

        $this->parents[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->objects, $this->controllers, $this->parents);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidController_throwsRodsonException() {

        $this->controllers[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->objects, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyControllers_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->objects, []);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidEntity_throwsRodsonException() {

        $this->objects[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->objects, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyObjects_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson($this->name, [], $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson('', $this->objects, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson(new \DateTime(), $this->objects, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
