<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteProject;
use iRESTful\Rodson\DSLs\Domain\Projects\Exceptions\ProjectException;

final class ConcreteProjectTest extends \PHPUnit_Framework_TestCase {
    private $dslMock;
    private $objectMock;
    private $controllerMock;
    private $objects;
    private $controllers;
    private $parents;
    public function setUp() {
        $this->dslMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\DSL');
        $this->objectMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object');
        $this->controllerMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller');

        $this->objects = [
            $this->objectMock,
            $this->objectMock
        ];

        $this->controllers = [
            $this->controllerMock,
            $this->controllerMock,
            $this->controllerMock
        ];

        $this->parents = [
            $this->dslMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $project = new ConcreteProject($this->objects, $this->controllers);

        $this->assertEquals($this->objects, $project->getObjects());
        $this->assertEquals($this->controllers, $project->getControllers());
        $this->assertFalse($project->hasParents());
        $this->assertNull($project->getParents());

    }

    public function testCreate_withEmptyParents_Success() {

        $project = new ConcreteProject($this->objects, $this->controllers, []);

        $this->assertEquals($this->objects, $project->getObjects());
        $this->assertEquals($this->controllers, $project->getControllers());
        $this->assertFalse($project->hasParents());
        $this->assertNull($project->getParents());

    }

    public function testCreate_withParents_Success() {

        $project = new ConcreteProject($this->objects, $this->controllers, $this->parents);

        $this->assertEquals($this->objects, $project->getObjects());
        $this->assertEquals($this->controllers, $project->getControllers());
        $this->assertTrue($project->hasParents());
        $this->assertEquals($this->parents, $project->getParents());

    }

    public function testCreate_withOneInvalidObject_throwsProjectException() {

        $this->objects[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteProject($this->objects, $this->controllers, $this->parents);

        } catch (ProjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidController_throwsProjectException() {

        $this->controllers[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteProject($this->objects, $this->controllers, $this->parents);

        } catch (ProjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidParent_throwsProjectException() {

        $this->parents[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteProject($this->objects, $this->controllers, $this->parents);

        } catch (ProjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyObjects_throwsProjectException() {

        $asserted = false;
        try {

            new ConcreteProject([], $this->controllers, $this->parents);

        } catch (ProjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyControllers_throwsProjectException() {

        $this->controllers[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteProject($this->objects, [], $this->parents);

        } catch (ProjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
