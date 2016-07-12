<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteMethodAdapter;
use iRESTful\Rodson\Tests\Helpers\Objects\PropertyHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\ReturnedInterfaceAdapterHelper;
use iRESTful\Rodson\Domain\Outputs\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Tests\Helpers\Adapters\ParameterAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\TypeHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\AdapterHelper;

final class ConcreteMethodAdapterTest extends \PHPUnit_Framework_TestCase {
    private $returnedInterfaceAdapterMock;
    private $returnedInterfaceMock;
    private $parameterAdapterMock;
    private $parameterMock;
    private $propertyMock;
    private $propertyTypeMock;
    private $adapterMock;
    private $typeMock;
    private $methodName;
    private $propertyName;
    private $data;
    private $adapter;
    private $returnedInterfaceAdapterHelper;
    private $parameterAdapterHelper;
    private $propertyHelper;
    private $adapterHelper;
    private $typeHelper;
    public function setUp() {
        $this->returnedInterfaceAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter');
        $this->returnedInterfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Returns\ReturnedInterface');
        $this->parameterAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter');
        $this->parameterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Parameter');
        $this->propertyMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property');
        $this->propertyTypeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type');
        $this->adapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Adapters\Adapter');
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Types\Type');

        $this->methodName = 'getOneElement';
        $this->propertyName = 'one_element';

        $this->data = [
            'name' => $this->methodName
        ];

        $this->adapter = new ConcreteMethodAdapter($this->returnedInterfaceAdapterMock, $this->parameterAdapterMock);

        $this->returnedInterfaceAdapterHelper = new ReturnedInterfaceAdapterHelper($this, $this->returnedInterfaceAdapterMock);
        $this->parameterAdapterHelper = new ParameterAdapterHelper($this, $this->parameterAdapterMock);
        $this->adapterHelper = new AdapterHelper($this, $this->adapterMock);
        $this->propertyHelper = new PropertyHelper($this, $this->propertyMock);
        $this->typeHelper = new TypeHelper($this, $this->typeMock);
    }

    public function tearDown() {

    }

    public function testFromPropertyToMethod_Success() {

        $this->propertyHelper->expectsGetName_Success($this->propertyName);
        $this->propertyHelper->expectsGetType_Success($this->propertyTypeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromPropertyTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->propertyTypeMock);

        $method = $this->adapter->fromPropertyToMethod($this->propertyMock);

        $this->assertEquals($this->methodName, $method->getName());
        $this->assertTrue($method->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $method->getReturnedType());
        $this->assertFalse($method->hasParameters());
        $this->assertNull($method->getParameters());

    }

    public function testFromPropertyToMethod_throwsReturnedInterfaceException_throwsMethodException() {

        $this->propertyHelper->expectsGetName_Success($this->propertyName);
        $this->propertyHelper->expectsGetType_Success($this->propertyTypeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromPropertyTypeToReturnedInterface_throwsReturnedInterfaceException($this->propertyTypeMock);

        $asserted = false;
        try {

            $this->adapter->fromPropertyToMethod($this->propertyMock);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromPropertiesToMethods_Success() {
        $this->propertyHelper->expectsGetName_Success($this->propertyName);
        $this->propertyHelper->expectsGetType_Success($this->propertyTypeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromPropertyTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->propertyTypeMock);

        $methods = $this->adapter->fromPropertiesToMethods([$this->propertyMock]);

        $this->assertEquals($this->methodName, $methods[0]->getName());
        $this->assertTrue($methods[0]->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $methods[0]->getReturnedType());
        $this->assertFalse($methods[0]->hasParameters());
        $this->assertNull($methods[0]->getParameters());
    }

    public function testFromDataToMethod_Success() {

        $method = $this->adapter->fromDataToMethod(['name' => $this->methodName]);

        $this->assertEquals($this->methodName, $method->getName());
        $this->assertFalse($method->hasReturnedType());
        $this->assertNull($method->getReturnedType());
        $this->assertFalse($method->hasParameters());
        $this->assertNull($method->getParameters());

    }

    public function testFromDataToMethod_withoutName_throwsMethodException() {

        $asserted = false;
        try {

            $this->adapter->fromDataToMethod([]);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToMethods_Success() {

        $methods = $this->adapter->fromDataToMethods([['name' => $this->methodName]]);

        $this->assertEquals($this->methodName, $methods[0]->getName());
        $this->assertFalse($methods[0]->hasReturnedType());
        $this->assertNull($methods[0]->getReturnedType());
        $this->assertFalse($methods[0]->hasParameters());
        $this->assertNull($methods[0]->getParameters());

    }

    public function testFromTypeToMethods_Success() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(false);
        $this->typeHelper->expectsHasViewAdapter_Success(false);

        $methods = $this->adapter->fromTypeToMethods($this->typeMock);

        $this->assertEquals([], $methods);

    }

    public function testFromTypeToMethods_withDatabaseAdapter_withFromType_Success() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(true);
        $this->typeHelper->expectsGetDatabaseAdapter_Success($this->adapterMock);
        $this->typeHelper->expectsGetName_multiple_Success(['MainType', 'FromType']);
        $this->adapterHelper->expectsHasFromType_Success(true);
        $this->adapterHelper->expectsFromType_Success($this->typeMock);
        $this->adapterHelper->expectsHasToType_Success(false);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->typeMock);
        $this->parameterAdapterHelper->expectsFromTypeToParameter_Success($this->parameterMock, $this->typeMock);
        $this->typeHelper->expectsHasViewAdapter_Success(false);

        $methods = $this->adapter->fromTypeToMethods($this->typeMock);

        $this->assertEquals('fromFromTypeToMainType', $methods[0]->getName());
        $this->assertTrue($methods[0]->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $methods[0]->getReturnedType());
        $this->assertTrue($methods[0]->hasParameters());
        $this->assertEquals([$this->parameterMock], $methods[0]->getParameters());
        $this->assertFalse(isset($methods[1]));

    }

    public function testFromTypeToMethods_withDatabaseAdapter_withFromType_withToType_Success() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(true);
        $this->typeHelper->expectsGetDatabaseAdapter_Success($this->adapterMock);
        $this->typeHelper->expectsGetName_multiple_Success(['MainType', 'FromType', 'ToType']);
        $this->adapterHelper->expectsHasFromType_Success(true);
        $this->adapterHelper->expectsFromType_Success($this->typeMock);
        $this->adapterHelper->expectsHasToType_Success(true);
        $this->adapterHelper->expectsToType_Success($this->typeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->typeMock);
        $this->parameterAdapterHelper->expectsFromTypeToParameter_Success($this->parameterMock, $this->typeMock);
        $this->typeHelper->expectsHasViewAdapter_Success(false);

        $methods = $this->adapter->fromTypeToMethods($this->typeMock);

        $this->assertEquals('fromFromTypeToToType', $methods[0]->getName());
        $this->assertTrue($methods[0]->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $methods[0]->getReturnedType());
        $this->assertTrue($methods[0]->hasParameters());
        $this->assertEquals([$this->parameterMock], $methods[0]->getParameters());
        $this->assertFalse(isset($methods[1]));

    }

    public function testFromTypeToMethods_withDatabaseAdapter_withToType_Success() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(true);
        $this->typeHelper->expectsGetDatabaseAdapter_Success($this->adapterMock);
        $this->typeHelper->expectsGetName_multiple_Success(['MainType', 'ToType']);
        $this->adapterHelper->expectsHasFromType_Success(false);
        $this->adapterHelper->expectsHasToType_Success(true);
        $this->adapterHelper->expectsToType_Success($this->typeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->typeMock);
        $this->parameterAdapterHelper->expectsFromTypeToParameter_Success($this->parameterMock, $this->typeMock);
        $this->typeHelper->expectsHasViewAdapter_Success(false);

        $methods = $this->adapter->fromTypeToMethods($this->typeMock);

        $this->assertEquals('fromMainTypeToToType', $methods[0]->getName());
        $this->assertTrue($methods[0]->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $methods[0]->getReturnedType());
        $this->assertTrue($methods[0]->hasParameters());
        $this->assertEquals([$this->parameterMock], $methods[0]->getParameters());
        $this->assertFalse(isset($methods[1]));

    }

    public function testFromTypeToMethods_withViewAdapter_withFromType_withToType_Success() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(false);
        $this->typeHelper->expectsHasViewAdapter_Success(true);
        $this->typeHelper->expectsGetViewAdapter_Success($this->adapterMock);
        $this->typeHelper->expectsGetName_multiple_Success(['MainType', 'FromType', 'ToType']);
        $this->adapterHelper->expectsHasFromType_Success(true);
        $this->adapterHelper->expectsFromType_Success($this->typeMock);
        $this->adapterHelper->expectsHasToType_Success(true);
        $this->adapterHelper->expectsToType_Success($this->typeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->typeMock);
        $this->parameterAdapterHelper->expectsFromTypeToParameter_Success($this->parameterMock, $this->typeMock);

        $methods = $this->adapter->fromTypeToMethods($this->typeMock);

        $this->assertEquals('fromFromTypeToToType', $methods[0]->getName());
        $this->assertTrue($methods[0]->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $methods[0]->getReturnedType());
        $this->assertTrue($methods[0]->hasParameters());
        $this->assertEquals([$this->parameterMock], $methods[0]->getParameters());
        $this->assertFalse(isset($methods[1]));

    }

    public function testFromTypeToMethods_withViewAdapter_withFromType_withToType_throwsParameterException_throwsMethodException() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(false);
        $this->typeHelper->expectsHasViewAdapter_Success(true);
        $this->typeHelper->expectsGetViewAdapter_Success($this->adapterMock);
        $this->typeHelper->expectsGetName_multiple_Success(['MainType', 'FromType', 'ToType']);
        $this->adapterHelper->expectsHasFromType_Success(true);
        $this->adapterHelper->expectsFromType_Success($this->typeMock);
        $this->adapterHelper->expectsHasToType_Success(true);
        $this->adapterHelper->expectsToType_Success($this->typeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_Success($this->returnedInterfaceMock, $this->typeMock);
        $this->parameterAdapterHelper->expectsFromTypeToParameter_throwsParameterException($this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromTypeToMethods($this->typeMock);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromTypeToMethods_withViewAdapter_withFromType_withToType_throwsReturnedInterfaceException_throwsMethodException() {

        $this->typeHelper->expectsHasDatabaseAdapter_Success(false);
        $this->typeHelper->expectsHasViewAdapter_Success(true);
        $this->typeHelper->expectsGetViewAdapter_Success($this->adapterMock);
        $this->typeHelper->expectsGetName_multiple_Success(['MainType', 'FromType', 'ToType']);
        $this->adapterHelper->expectsHasFromType_Success(true);
        $this->adapterHelper->expectsFromType_Success($this->typeMock);
        $this->adapterHelper->expectsHasToType_Success(true);
        $this->adapterHelper->expectsToType_Success($this->typeMock);
        $this->returnedInterfaceAdapterHelper->expectsFromTypeToReturnedInterface_throwsReturnedInterfaceException($this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromTypeToMethods($this->typeMock);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
