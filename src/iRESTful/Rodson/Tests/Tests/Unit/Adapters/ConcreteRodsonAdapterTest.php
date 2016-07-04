<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRodsonAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\ControllerAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\ObjectAdapterHelper;
use iRESTful\Rodson\Domain\Exceptions\RodsonException;

final class ConcreteRodsonAdapterTest extends \PHPUnit_Framework_TestCase {
    private $objectAdapterMock;
    private $objectMock;
    private $controllerAdapterMock;
    private $controllerMock;
    private $rodsonMock;
    private $name;
    private $parentName;
    private $objects;
    private $controllers;
    private $parents;
    private $data;
    private $dataWithParents;
    private $adapter;
    private $objectAdapterHelper;
    private $controllerAdapterHelper;
    public function setUp() {
        $this->objectAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Adapters\ObjectAdapter');
        $this->objectMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Object');
        $this->controllerAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Controllers\Adapters\ControllerAdapter');
        $this->controllerMock = $this->getMock('iRESTful\Rodson\Domain\Controllers\Controller');
        $this->rodsonMock = $this->getMock('iRESTful\Rodson\Domain\Rodson');

        $this->name = 'my_rodson';
        $this->parentName = 'authenticated';

        $this->objects = [
            $this->objectMock,
            $this->objectMock
        ];

        $this->controllers = [
            $this->controllerMock,
            $this->controllerMock
        ];

        $this->parents = [
            $this->rodsonMock
        ];

        $this->data = [
            'name' => $this->name,
            'objects' => [
                'some' => 'objects'
            ],
            'controllers' => [
                'some' => 'controller'
            ]
        ];

        $this->dataWithParents = [
            'name' => $this->name,
            'objects' => [
                'some' => 'objects'
            ],
            'controllers' => [
                'some' => 'controller'
            ],
            'parents' => [
                [
                    'name' => $this->parentName,
                    'objects' => [
                        'parent' => 'objects'
                    ],
                    'controllers' => [
                        'parent' => 'controller'
                    ]
                ]
            ]
        ];

        $this->adapter = new ConcreteRodsonAdapter($this->objectAdapterMock, $this->controllerAdapterMock);

        $this->objectAdapterHelper = new ObjectAdapterHelper($this, $this->objectAdapterMock);
        $this->controllerAdapterHelper = new ControllerAdapterHelper($this, $this->controllerAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToRodson_Success() {

        $this->objectAdapterHelper->expectsFromDataToObjects_Success($this->objects, $this->data['objects']);
        $this->controllerAdapterHelper->expectsFromDataToControllers_Success($this->controllers, $this->data['controllers']);

        $rodson = $this->adapter->fromDataToRodson($this->data);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertFalse($rodson->hasParents());
        $this->assertNull($rodson->getParents());

    }

    public function testFromDataToRodson_witParents_Success() {

        $this->objectAdapterHelper->expectsFromDataToObjects_multiple_Success(
            [$this->objects, $this->objects],
            [$this->dataWithParents['objects'], $this->dataWithParents['parents'][0]['objects']]
        );

        $this->controllerAdapterHelper->expectsFromDataToControllers_multiple_Success(
            [$this->controllers, $this->controllers],
            [$this->dataWithParents['controllers'], $this->dataWithParents['parents'][0]['controllers']]
        );

        $rodson = $this->adapter->fromDataToRodson($this->dataWithParents);

        $this->assertEquals($this->name, $rodson->getName());
        $this->assertEquals($this->objects, $rodson->getObjects());
        $this->assertEquals($this->controllers, $rodson->getControllers());
        $this->assertTrue($rodson->hasParents());

        $parents = $rodson->getParents();
        $this->assertEquals($this->dataWithParents['parents'][0]['name'], $parents[0]->getName());
        $this->assertEquals($this->objects, $parents[0]->getObjects());
        $this->assertEquals($this->controllers, $parents[0]->getControllers());
        $this->assertFalse($parents[0]->hasParents());
        $this->assertNull($parents[0]->getParents());

    }

    public function testFromDataToRodson_throwsControllerException_throwsRodsonException() {

        $this->objectAdapterHelper->expectsFromDataToObjects_Success($this->objects, $this->data['objects']);
        $this->controllerAdapterHelper->expectsFromDataToControllers_throwsControllerException($this->data['controllers']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRodson($this->data);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRodson_throwsObjectException_throwsRodsonException() {

        $this->objectAdapterHelper->expectsFromDataToObjects_throwsObjectException($this->data['objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRodson($this->data);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRodson_withoutControllers_throwsRodsonException() {

        unset($this->data['controllers']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRodson($this->data);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRodson_withoutObjects_throwsRodsonException() {

        unset($this->data['objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRodson($this->data);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRodson_withoutName_throwsRodsonException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRodson($this->data);

        } catch (RodsonException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRodsons_Success() {

        $this->objectAdapterHelper->expectsFromDataToObjects_Success($this->objects, $this->data['objects']);
        $this->controllerAdapterHelper->expectsFromDataToControllers_Success($this->controllers, $this->data['controllers']);

        $rodsons = $this->adapter->fromDataToRodsons([$this->data]);

        $this->assertEquals($this->name, $rodsons[0]->getName());
        $this->assertEquals($this->objects, $rodsons[0]->getObjects());
        $this->assertEquals($this->controllers, $rodsons[0]->getControllers());
        $this->assertFalse($rodsons[0]->hasParents());
        $this->assertNull($rodsons[0]->getParents());

    }

}
