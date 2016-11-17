<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ObjectAdapterFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ObjectAdapterFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $objectAdapterFactoryAdapterMock;
    private $objectAdapterFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->objectAdapterFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\Adapters\ObjectAdapterFactoryAdapter');
        $this->objectAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory');

        $this->data = [
            'some' => 'input'
        ];

        $this->helper = new ObjectAdapterFactoryAdapterHelper($this, $this->objectAdapterFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToObjectAdapterFactory_Success() {

        $this->helper->expectsFromDataToObjectAdapterFactory_Success($this->objectAdapterFactoryMock, $this->data);

        $factory = $this->objectAdapterFactoryAdapterMock->fromDataToObjectAdapterFactory($this->data);

        $this->assertEquals($this->objectAdapterFactoryMock, $factory);

    }

    public function testFromDataToObjectAdapterFactory_throwsObjectException() {

        $this->helper->expectsFromDataToObjectAdapterFactory_throwsObjectException($this->data);

        $asserted = false;
        try {

            $this->objectAdapterFactoryAdapterMock->fromDataToObjectAdapterFactory($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
