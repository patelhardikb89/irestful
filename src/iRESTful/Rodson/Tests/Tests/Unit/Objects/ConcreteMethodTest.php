<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethod;
use iRESTful\Rodson\Domain\Outputs\Methods\Exceptions\MethodException;

final class ConcreteMethodTest extends \PHPUnit_Framework_TestCase {
    private $returnedInterfaceMock;
    private $parameterMock;
    private $name;
    private $parameters;
    public function setUp() {
        $this->returnedInterfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Returns\ReturnedInterface');
        $this->parameterMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Parameter');

        $this->name = 'getProperty';

        $this->parameters = [
            $this->parameterMock,
            $this->parameterMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $method = new ConcreteMethod($this->name);

        $this->assertEquals($this->name, $method->getName());
        $this->assertFalse($method->hasReturnedType());
        $this->assertNull($method->getReturnedType());
        $this->assertFalse($method->hasParameters());
        $this->assertNull($method->getParameters());

    }

    public function testCreate_withReturnedType_Success() {

        $method = new ConcreteMethod($this->name, $this->returnedInterfaceMock);

        $this->assertEquals($this->name, $method->getName());
        $this->assertTrue($method->hasReturnedType());
        $this->assertEquals($this->returnedInterfaceMock, $method->getReturnedType());
        $this->assertFalse($method->hasParameters());
        $this->assertNull($method->getParameters());

    }

    public function testCreate_withParameters_Success() {

        $method = new ConcreteMethod($this->name, null, $this->parameters);

        $this->assertEquals($this->name, $method->getName());
        $this->assertFalse($method->hasReturnedType());
        $this->assertNull($method->getReturnedType());
        $this->assertTrue($method->hasParameters());
        $this->assertEquals($this->parameters, $method->getParameters());

    }

    public function testCreate_withReturnedType_withParameters_Success() {

        $method = new ConcreteMethod($this->name, $this->returnedInterfaceMock, $this->parameters);

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

            new ConcreteMethod($this->name, null, $this->parameters);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteMethod('');

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteMethod(new \DateTime());

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
