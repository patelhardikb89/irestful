<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteInterfaceMethod;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Exceptions\MethodException;

final class ConcreteInterfaceMethodTest extends \PHPUnit_Framework_TestCase {
    private $returnedInterfaceMock;
    private $parameterMock;
    private $name;
    private $parameters;
    public function setUp() {
        $this->returnedInterfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\ReturnedInterface');
        $this->parameterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Parameter');

        $this->name = 'getProperty';

        $this->parameters = [
            $this->parameterMock,
            $this->parameterMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $method = new ConcreteInterfaceMethod($this->name);

        $this->assertEquals($this->name, $method->getName());
        $this->assertFalse($method->hasReturnedType());
        $this->assertNull($method->getReturnedType());
        $this->assertFalse($method->hasParameters());
        $this->assertNull($method->getParameters());

    }

    public function testCreate_withReturnedType_Success() {

        $method = new ConcreteInterfaceMethod($this->name, $this->returnedInterfaceMock);

        $this->assertEquals($this->name, $method->getName());
        $this->assertTrue($method->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $method->getReturnedType());
        $this->assertFalse($method->hasParameters());
        $this->assertNull($method->getParameters());

    }

    public function testCreate_withParameters_Success() {

        $method = new ConcreteInterfaceMethod($this->name, null, $this->parameters);

        $this->assertEquals($this->name, $method->getName());
        $this->assertFalse($method->hasReturnedType());
        $this->assertNull($method->getReturnedType());
        $this->assertTrue($method->hasParameters());
        $this->assertEquals($this->parameters, $method->getParameters());

    }

    public function testCreate_withReturnedType_withParameters_Success() {

        $method = new ConcreteInterfaceMethod($this->name, $this->returnedInterfaceMock, $this->parameters);

        $this->assertEquals($this->name, $method->getName());
        $this->assertTrue($method->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $method->getReturnedType());
        $this->assertTrue($method->hasParameters());
        $this->assertEquals($this->parameters, $method->getParameters());

    }

    public function testCreate_withReturnedType_withParameters_withOneInvalidParameter_throwsMethodException() {

        $this->parameters[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteInterfaceMethod($this->name, null, $this->parameters);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteInterfaceMethod('');

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteInterfaceMethod(new \DateTime());

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
