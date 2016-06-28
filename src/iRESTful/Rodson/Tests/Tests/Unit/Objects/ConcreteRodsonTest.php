<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteRodson;
use iRESTful\Rodson\Domain\Exceptions\RodsonException;

final class ConcreteRodsonTest extends \PHPUnit_Framework_TestCase {
    private $rodsonMock;
    private $entityMock;
    private $controllerMock;
    private $name;
    private $parents;
    private $entities;
    private $controllers;
    public function setUp() {
        $this->rodsonMock = $this->getMock('iRESTful\Rodson\Domain\Rodson');
        $this->entityMock = $this->getMock('iRESTful\Rodson\Domain\Entities\Entity');
        $this->controllerMock = $this->getMock('iRESTful\Rodson\Domain\Controllers\Controller');

        $this->name = 'MyProject';

        $this->parents = [
            $this->rodsonMock,
            $this->rodsonMock
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->controllers = [
            $this->controllerMock,
            $this->controllerMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $rodson = new ConcreteRodson($this->name, $this->entities, $this->controllers);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->entities, $rodson->getEntities());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertFalse($rodson->hasParents());
        $this->assertNull($rodson->getParents());

    }

    public function testCreate_withParents_Success() {

        $rodson = new ConcreteRodson($this->name, $this->entities, $this->controllers, $this->parents);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->entities, $rodson->getEntities());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertTrue($rodson->hasParents());
        $this->assertEquals($this->parents, $rodson->getParents());

    }

    public function testCreate_withInvalidIndexInParents_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->entities, $this->controllers, ['some' => $this->rodsonMock]);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidParent_throwsRodsonException() {

        $this->parents[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->entities, $this->controllers, $this->parents);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidIndexInControllers_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->entities, ['some' => $this->controllerMock]);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidController_throwsRodsonException() {

        $this->controllers[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->entities, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyControllers_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->entities, []);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidIndexInEntities_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson($this->name, ['some' => $this->entityMock], $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidEntity_throwsRodsonException() {

        $this->entities[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteRodson($this->name, $this->entities, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyEntities_throwsRodsonException() {

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

            new ConcreteRodson('', $this->entities, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsRodsonException() {

        $asserted = false;
        try {

            new ConcreteRodson(new \DateTime(), $this->entities, $this->controllers);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
