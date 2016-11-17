<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ObjectAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ObjectAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $objectAdapterMock;
    private $object;
    private $objects;
    private $objectsMap;
    private $objectsMaps;
    private $helper;
    public function setUp() {

        $this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');

        $this->object = new \DateTime();
        $this->objects = [
            new \DateTime(),
            new \DateTime()
        ];

        $this->objectsMap = [
            'first_keyname' => [
                new \DateTime(),
                new \DateTime()
            ],
            'second_keyname' => [
                new \DateTime()
            ]
        ];

        $this->objectsMaps = [
            [],
            $this->objectsMap,
            []
        ];

        $this->helper = new ObjectAdapterHelper($this, $this->objectAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromObjectToSubObjects_Success() {

        $this->helper->expectsFromObjectToSubObjects_Success($this->objects, $this->object);

        $objects = $this->objectAdapterMock->fromObjectToSubObjects($this->object);

        $this->assertEquals($this->objects, $objects);

    }

    public function testFromObjectToSubObjects_throwsObjectException() {

        $this->helper->expectsFromObjectToSubObjects_throwsObjectException($this->object);

        $asserted = false;
        try {

            $this->objectAdapterMock->fromObjectToSubObjects($this->object);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromObjectsToSubObjects_Success() {

        $this->helper->expectsFromObjectsToSubObjects_Success($this->objects, $this->objects);

        $objects = $this->objectAdapterMock->fromObjectsToSubObjects($this->objects);

        $this->assertEquals($this->objects, $objects);

    }

    public function testFromObjectsToSubObjects_throwsObjectException() {

        $this->helper->expectsFromObjectsToSubObjects_throwsObjectException($this->objects);

        $asserted = false;
        try {

            $this->objectAdapterMock->fromObjectsToSubObjects($this->objects);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromObjectToRelationObjects_Success() {

        $this->helper->expectsFromObjectToRelationObjects_Success($this->objectsMap, $this->object);

        $relationObjects = $this->objectAdapterMock->fromObjectToRelationObjects($this->object);

        $this->assertEquals($this->objectsMap, $relationObjects);

    }

    public function testFromObjectToRelationObjects_throwsObjectException() {

        $this->helper->expectsFromObjectToRelationObjects_throwsObjectException($this->object);

        $asserted = false;
        try {

            $this->objectAdapterMock->fromObjectToRelationObjects($this->object);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromObjectsToRelationObjectsList_Success() {

        $this->helper->expectsFromObjectsToRelationObjectsList_Success($this->objectsMaps, $this->objects);

        $relationObjects = $this->objectAdapterMock->fromObjectsToRelationObjectsList($this->objects);

        $this->assertEquals($this->objectsMaps, $relationObjects);
    }

    public function testFromObjectsToRelationObjectsList_throwsObjectException() {

        $this->helper->expectsFromObjectsToRelationObjectsList_throwsObjectException($this->objects);

        $asserted = false;
        try {

            $this->objectAdapterMock->fromObjectsToRelationObjectsList($this->objects);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
