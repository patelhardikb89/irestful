<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteMethodParameterAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\ReturnedInterfaceAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\TypeHelper;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteMethodParameterAdapterTest extends \PHPUnit_Framework_TestCase {
    private $returnedInterfaceAdapterMock;
    private $returnedInterfaceMock;
    private $typeMock;
    private $typeName;
    private $name;
    private $adapter;
    private $typeHelper;
    private $returnedInterfaceAdapterHelper;
    public function setUp() {
        $this->returnedInterfaceAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter');
        $this->returnedInterfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Returns\ReturnedInterface');
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Types\Type');

        $this->typeName = 'MyTypeName';
        $this->name = 'myTypeName';

        $this->adapter = new ConcreteMethodParameterAdapter($this->returnedInterfaceAdapterMock);

        $this->typeHelper = new TypeHelper($this, $this->typeMock);
        $this->returnedInterfaceAdapterHelper = new ReturnedInterfaceAdapterHelper($this, $this->returnedInterfaceAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromTypeToParameter_Success() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->typeMock);

        $parameter = $this->adapter->fromTypeToParameter($this->typeMock);

        $this->assertEquals($this->name, $parameter->getName());
        $this->assertTrue($parameter->hasReturnedInterface());
        $this->assertEquals($this->returnedInterfaceMock, $parameter->getReturnedInterface());

    }

    public function testFromTypeToParameter_throwsReturnedInterfaceException_throwsParameterException() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_throwsReturnedInterfaceException($this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromTypeToParameter($this->typeMock);

        } catch (ParameterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
