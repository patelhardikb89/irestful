<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteInterface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;

final class ConcreteInterfaceTest extends \PHPUnit_Framework_TestCase {
    private $interfaceMock;
    private $namespaceMock;
    private $methodMock;
    private $name;
    private $methods;
    private $subInterfaces;
    public function setUp() {
        $this->interfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Interfaces\ObjectInterface');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Method');
        $this->namespaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace');

        $this->name = 'MyInterface';
        $this->methods = [
            $this->methodMock,
            $this->methodMock
        ];

        $this->subInterfaces = [
            $this->interfaceMock,
            $this->interfaceMock
        ];

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $interface = new ConcreteInterface($this->name, $this->methods, $this->namespaceMock);

        $this->assertEquals($this->name, $interface->getName());
        $this->assertEquals($this->methods, $interface->getMethods());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertFalse($interface->hasSubInterfaces());
        $this->assertNull($interface->getSubInterfaces());

    }

    public function testCreate_withEmptySubInterfaces_Success() {

        $interface = new ConcreteInterface($this->name, $this->methods, $this->namespaceMock, []);

        $this->assertEquals($this->name, $interface->getName());
        $this->assertEquals($this->methods, $interface->getMethods());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertFalse($interface->hasSubInterfaces());
        $this->assertNull($interface->getSubInterfaces());

    }

    public function testCreate_withSubInterfaces_Success() {

        $interface = new ConcreteInterface($this->name, $this->methods, $this->namespaceMock, $this->subInterfaces);

        $this->assertEquals($this->name, $interface->getName());
        $this->assertEquals($this->methods, $interface->getMethods());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertTrue($interface->hasSubInterfaces());
        $this->assertEquals($this->subInterfaces, $interface->getSubInterfaces());

    }

    public function testCreate_withSubInterfaces_withOneInvalidSubInterface_throwsInterfaceException() {

        $this->subInterfaces[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteInterface($this->name, $this->methods, $this->namespaceMock, $this->subInterfaces);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withSubInterfaces_withOneInvalidMethod_throwsInterfaceException() {

        $this->methods[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteInterface($this->name, $this->methods, $this->namespaceMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withSubInterfaces_withEmptyMethods_throwsInterfaceException() {

        $asserted = false;
        try {

            new ConcreteInterface($this->name, [], $this->namespaceMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsInterfaceException() {

        $asserted = false;
        try {

            new ConcreteInterface('', $this->methods, $this->namespaceMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsInterfaceException() {

        $asserted = false;
        try {

            new ConcreteInterface(new \DateTime(), $this->methods, $this->namespaceMock);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
