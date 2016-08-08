<?php
namespace iRESTful\Rodson\Tests\Middles\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Exceptions\InterfaceException;

final class ConcreteClassInterfaceTest extends \PHPUnit_Framework_TestCase {
    private $namespaceMock;
    private $methodMock;
    private $name;
    private $methods;
    public function setUp() {
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Method');
        $this->namespaceMock = $this->getMock('iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace');

        $this->name = 'MyInterface';
        $this->methods = [
            $this->methodMock,
            $this->methodMock
        ];

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $interface = new ConcreteClassInterface($this->name, $this->methods, $this->namespaceMock, false);

        $this->assertEquals($this->name, $interface->getName());
        $this->assertEquals($this->methods, $interface->getMethods());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertFalse($interface->isEntity());

    }

    public function testCreate_isEntity_Success() {

        $interface = new ConcreteClassInterface($this->name, $this->methods, $this->namespaceMock, true);

        $this->assertEquals($this->name, $interface->getName());
        $this->assertEquals($this->methods, $interface->getMethods());
        $this->assertEquals($this->namespaceMock, $interface->getNamespace());
        $this->assertTrue($interface->isEntity());

    }

    public function testCreate_withOneInvalidMethod_throwsInterfaceException() {

        $this->methods[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteClassInterface($this->name, $this->methods, $this->namespaceMock, false);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyMethods_throwsInterfaceException() {

        $asserted = false;
        try {

            new ConcreteClassInterface($this->name, [], $this->namespaceMock, false);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsInterfaceException() {

        $asserted = false;
        try {

            new ConcreteClassInterface('', $this->methods, $this->namespaceMock, false);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsInterfaceException() {

        $asserted = false;
        try {

            new ConcreteClassInterface(new \DateTime(), $this->methods, $this->namespaceMock, false);

        } catch (InterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
