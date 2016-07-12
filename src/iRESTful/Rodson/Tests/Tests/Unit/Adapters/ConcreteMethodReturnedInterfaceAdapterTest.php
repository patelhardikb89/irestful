<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteMethodReturnedInterfaceAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\NamespaceAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\TypeHelper;
use iRESTful\Rodson\Tests\Helpers\Objects\ObjectHelper;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;
use iRESTful\Rodson\Tests\Helpers\Objects\PropertyTypeHelper;

final class ConcreteMethodReturnedInterfaceAdapterTest extends \PHPUnit_Framework_TestCase {
    private $namespaceAdapterMock;
    private $namespaceMock;
    private $propertyTypeMock;
    private $typeMock;
    private $objectMock;
    private $typeName;
    private $objectName;
    private $typeInterfaceName;
    private $objectInterfaceName;
    private $adapter;
    private $namespaceAdapterHelper;
    private $propertyTypeHelper;
    private $typeHelper;
    private $objectHelper;
    public function setUp() {
        $this->namespaceAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter');
        $this->namespaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace');
        $this->propertyTypeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type');
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Types\Type');
        $this->objectMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Object');

        $this->typeName = 'base_url';
        $this->objectName = 'role';
        $this->typeInterfaceName = 'BaseUrl';
        $this->objectInterfaceName = 'Role';

        $this->adapter = new ConcreteMethodReturnedInterfaceAdapter($this->namespaceAdapterMock);

        $this->namespaceAdapterHelper = new NamespaceAdapterHelper($this, $this->namespaceAdapterMock);
        $this->propertyTypeHelper = new PropertyTypeHelper($this, $this->propertyTypeMock);
        $this->typeHelper = new TypeHelper($this, $this->typeMock);
        $this->objectHelper = new ObjectHelper($this, $this->objectMock);
    }

    public function tearDown() {

    }

    public function testFromTypeToReturnedInterface_Success() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->typeInterfaceName]);

        $returnedInterface = $this->adapter->fromTypeToReturnedInterface($this->typeMock);

        $this->assertEquals($this->typeInterfaceName, $returnedInterface->getName());
        $this->assertEquals($this->namespaceMock, $returnedInterface->getNamespace());

    }

    public function testFromTypeToReturnedInterface_throwsNamespaceException_throwsReturnedInterfaceException() {

        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_throwsNamespaceException([$this->typeInterfaceName]);

        $asserted = false;
        try {

            $this->adapter->fromTypeToReturnedInterface($this->typeMock);

        } catch (ReturnedInterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromObjectToReturnedInterface_Success() {

        $this->objectHelper->expectsGetName_Success($this->objectInterfaceName);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->objectInterfaceName]);

        $returnedInterface = $this->adapter->fromObjectToReturnedInterface($this->objectMock);

        $this->assertEquals($this->objectInterfaceName, $returnedInterface->getName());
        $this->assertEquals($this->namespaceMock, $returnedInterface->getNamespace());

    }

    public function testFromObjectToReturnedInterface_throwsNamespaceException_throwsReturnedInterfaceException() {

        $this->objectHelper->expectsGetName_Success($this->objectInterfaceName);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_throwsNamespaceException([$this->objectInterfaceName]);

        $asserted = false;
        try {

            $this->adapter->fromObjectToReturnedInterface($this->objectMock);

        } catch (ReturnedInterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromPropertyTypeToReturnedInterface_withType_Success() {

        $this->propertyTypeHelper->expectsHasType_Success(true);
        $this->propertyTypeHelper->expectsGetType_Success($this->typeMock);
        $this->typeHelper->expectsGetName_Success($this->typeName);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->typeInterfaceName]);

        $returnedInterface = $this->adapter->fromPropertyTypeToReturnedInterface($this->propertyTypeMock);

        $this->assertEquals($this->typeInterfaceName, $returnedInterface->getName());
        $this->assertEquals($this->namespaceMock, $returnedInterface->getNamespace());

    }

    public function testFromPropertyTypeToReturnedInterface_withObject_Success() {

        $this->propertyTypeHelper->expectsHasType_Success(false);
        $this->propertyTypeHelper->expectsHasObject_Success(true);
        $this->propertyTypeHelper->expectsGetObject_Success($this->objectMock);
        $this->objectHelper->expectsGetName_Success($this->objectInterfaceName);
        $this->namespaceAdapterHelper->expectsFromDataToNamespace_Success($this->namespaceMock, [$this->objectInterfaceName]);

        $returnedInterface = $this->adapter->fromPropertyTypeToReturnedInterface($this->propertyTypeMock);

        $this->assertEquals($this->objectInterfaceName, $returnedInterface->getName());
        $this->assertEquals($this->namespaceMock, $returnedInterface->getNamespace());

    }

    public function testFromPropertyTypeToReturnedInterface_withoutType_withoutObject_throwsReturnedInterfaceException() {

        $this->propertyTypeHelper->expectsHasType_Success(false);
        $this->propertyTypeHelper->expectsHasObject_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromPropertyTypeToReturnedInterface($this->propertyTypeMock);

        } catch (ReturnedInterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
