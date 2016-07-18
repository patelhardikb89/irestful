<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\OutputMethodAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\ObjectHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\TypeHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\NamespaceAdapterHelper;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Tests\Helpers\Objects\PropertyTypeHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\PropertyHelper;

final class ConcreteInterfaceAdapterTest extends \PHPUnit_Framework_TestCase {
    private $namespaceAdapterMock;
    private $namespaceMock;
    private $methodAdapterMock;
    private $methodMock;
    private $typeMock;
    private $propertyMock;
    private $propertyTypeMock;
    private $objectMock;
    private $objectName;
    private $secondObjectName;
    private $typeName;
    private $typeInterfaceName;
    private $objectInterfaceName;
    private $secondObjectInterfaceName;
    private $properties;
    private $methods;
    private $subMethods;
    private $adapter;
    private $namespaceAdapterHelper;
    private $methodAdapterHelper;
    private $propertyHelper;
    private $propertyTypeHelper;
    private $typeHelper;
    private $objectHelper;
    public function setUp() {
        $this->namespaceAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter');
        $this->namespaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace');
        $this->methodAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Method');
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Types\Type');
        $this->propertyMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property');
        $this->propertyTypeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type');
        $this->objectMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Object');

        $this->objectName = 'api';
        $this->secondObjectName = 'role';
        $this->typeName = 'base_url';
        $this->typeInterfaceName = 'BaseUrl';
        $this->objectInterfaceName = 'Api';
        $this->secondObjectInterfaceName = 'Role';

        $this->properties = [
            $this->propertyMock
        ];

        $this->methods = [
            $this->methodMock,
            $this->methodMock
        ];

        $this->subMethods = [
            $this->methodMock
        ];

        $this->adapter = new ConcreteInterfaceAdapter($this->methodAdapterMock, $this->namespaceAdapterMock);

        $this->namespaceAdapterHelper = new NamespaceAdapterHelper($this, $this->namespaceAdapterMock);
        $this->methodAdapterHelper = new OutputMethodAdapterHelper($this, $this->methodAdapterMock);
        $this->propertyHelper = new PropertyHelper($this, $this->propertyMock);
        $this->propertyTypeHelper = new PropertyTypeHelper($this, $this->propertyTypeMock);
        $this->typeHelper = new TypeHelper($this, $this->typeMock);
        $this->objectHelper = new ObjectHelper($this, $this->objectMock);
    }

    public function tearDown() {

    }

    public function testFromObjectToInterface_withTypeProperty_Success() {

        $this->objectHelper->expectsGetName_Success($this->objectName);
        $this->objectHelper->expectsGetProperties_Success($this->properties);
        $this->methodAdapterHelper->expectsFromPropertiesToMethods_Success($this->methods, $this->properties);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_multiple_Success(
            [$this->namespaceMock, $this->namespaceMock],
            [[$this->objectInterfaceName, $this->typeInterfaceName], [$this->objectInterfaceName]]
        );
        $this->propertyHelper->expectsGetType_Success($this->propertyTypeMock);
        $this->propertyTypeHelper->expectsHasType_Success(true);
        $this->propertyTypeHelper->expectsGetType_Success($this->typeMock);

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_Success($this->methodMock, ['name' => 'get']);
        $this->methodAdapterHelper->expectsFromTypeToMethods_Success([], $this->typeMock);

        $interface = $this->adapter->fromObjectToInterface($this->objectMock);

        $this->assertEquals($this->objectInterfaceName, $interface->getName());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertEquals($this->methods, $interface->getMethods());
    }

    public function testFromObjectToInterface_withObjectProperty_Success() {

        $this->objectHelper->expectsGetName_multiple_Success([$this->objectName, $this->secondObjectName]);
        $this->objectHelper->expectsGetProperties_multiple_Success([$this->properties, $this->properties]);
        $this->methodAdapterHelper->expectsFromPropertiesToMethods_multiple_Success(
            [$this->methods, $this->methods],
            [$this->properties, $this->properties]
        );

        $this->namespaceAdapterHelper->expectsFromDataToNamespace_multiple_Success(
            [$this->namespaceMock, $this->namespaceMock, $this->namespaceMock],
            [[$this->objectInterfaceName], [$this->objectInterfaceName, $this->secondObjectInterfaceName], [$this->objectInterfaceName, $this->secondObjectInterfaceName, $this->typeInterfaceName]]
        );

        $this->propertyHelper->expectsGetType_multiple_Success([$this->propertyTypeMock, $this->propertyTypeMock]);
        $this->propertyTypeHelper->expectsHasType_multiple_Success([false, true]);
        $this->propertyTypeHelper->expectsHasObject_Success(true);
        $this->propertyTypeHelper->expectsGetObject_Success($this->objectMock);

        $this->propertyTypeHelper->expectsGetType_Success($this->typeMock);
        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_Success($this->methodMock, ['name' => 'get']);
        $this->methodAdapterHelper->expectsFromTypeToMethods_Success([], $this->typeMock);

        $interface = $this->adapter->fromObjectToInterface($this->objectMock);

        $this->assertEquals($this->objectInterfaceName, $interface->getName());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertEquals($this->methods, $interface->getMethods());
    }

    public function testFromObjectToInterface_withoutTypeProperty_withoutObjectProperty_throwsInterfaceException() {

        $this->objectHelper->expectsGetName_Success($this->objectName);
        $this->objectHelper->expectsGetProperties_Success($this->properties);
        $this->methodAdapterHelper->expectsFromPropertiesToMethods_Success($this->methods, $this->properties);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->objectInterfaceName]);
        $this->propertyHelper->expectsGetType_Success($this->propertyTypeMock);
        $this->propertyTypeHelper->expectsHasType_Success(false);
        $this->propertyTypeHelper->expectsHasObject_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromObjectToInterface($this->objectMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromObjectToInterface_withTypeProperty_throwsMethodException_throwsInterfaceException() {

        $this->objectHelper->expectsGetName_Success($this->objectName);
        $this->objectHelper->expectsGetProperties_Success($this->properties);
        $this->methodAdapterHelper->expectsFromPropertiesToMethods_Success($this->methods, $this->properties);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_multiple_Success(
            [$this->namespaceMock, $this->namespaceMock],
            [[$this->objectInterfaceName], [$this->objectInterfaceName, $this->typeInterfaceName]]
        );
        $this->propertyHelper->expectsGetType_Success($this->propertyTypeMock);
        $this->propertyTypeHelper->expectsHasType_Success(true);
        $this->propertyTypeHelper->expectsGetType_Success($this->typeMock);

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_Success($this->methodMock, ['name' => 'get']);
        $this->methodAdapterHelper->expectsFromTypeToMethods_throwsMethodException($this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromObjectToInterface($this->objectMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromObjectToInterface_throwsNamespaceException_throwsInterfaceException() {

        $this->objectHelper->expectsGetName_Success($this->objectName);
        $this->objectHelper->expectsGetProperties_Success($this->properties);
        $this->methodAdapterHelper->expectsFromPropertiesToMethods_Success($this->methods, $this->properties);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_throwsNamespaceException([$this->objectInterfaceName]);

        $asserted = false;
        try {

            $this->adapter->fromObjectToInterface($this->objectMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromObjectToInterface_throwsMethodException_throwsInterfaceException() {

        $this->objectHelper->expectsGetName_Success($this->objectName);
        $this->objectHelper->expectsGetProperties_Success($this->properties);
        $this->methodAdapterHelper->expectsFromPropertiesToMethods_throwsMethodException($this->properties);

        $asserted = false;
        try {

            $this->adapter->fromObjectToInterface($this->objectMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromTypeToInterface_Success() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_Success($this->methodMock, ['name' => 'get']);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->typeInterfaceName]);
        $this->methodAdapterHelper->expectsFromTypeToMethods_Success([], $this->typeMock);

        $interface = $this->adapter->fromTypeToInterface($this->typeMock);

        $this->assertEquals($this->typeInterfaceName, $interface->getName());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
    }

    public function testFromTypeToInterface_throwsMethodException_throwsInterfaceException() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_Success($this->methodMock, ['name' => 'get']);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->typeInterfaceName]);
        $this->methodAdapterHelper->expectsFromTypeToMethods_throwsMethodException($this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromTypeToInterface($this->typeMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromTypeToInterface_throwsNamespaceException_throwsInterfaceException() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_Success($this->methodMock, ['name' => 'get']);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_throwsNamespaceException([$this->typeInterfaceName]);

        $asserted = false;
        try {

            $this->adapter->fromTypeToInterface($this->typeMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromTypeToInterface_throwsMethodException_onFromDataToMethods_throwsInterfaceException() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->methodAdapterHelper->expectsFromDataToMethod_throwsMethodException(['name' => 'get']);

        $asserted = false;
        try {

            $this->adapter->fromTypeToInterface($this->typeMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
