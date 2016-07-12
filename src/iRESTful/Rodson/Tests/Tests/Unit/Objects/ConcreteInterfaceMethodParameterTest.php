<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteInterfaceMethodParameter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteInterfaceMethodParameterTest extends \PHPUnit_Framework_TestCase {
    private $interfaceMock;
    private $name;
    public function setUp() {
        $this->interfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Interfaces\ObjectInterface');
        $this->name = 'myName';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $parameter = new ConcreteInterfaceMethodParameter($this->name);

        $this->assertEquals($this->name, $parameter->getName());
        $this->assertFalse($parameter->hasInterface());
        $this->assertNull($parameter->getInterface());

    }

    public function testCreate_withInterface_Success() {

        $parameter = new ConcreteInterfaceMethodParameter($this->name, $this->interfaceMock);

        $this->assertEquals($this->name, $parameter->getName());
        $this->assertTrue($parameter->hasInterface());
        $this->assertEquals($this->interfaceMock, $parameter->getInterface());

    }

    public function testCreate_withEmptyName_throwsParameterException() {

        $asserted = false;
        try {

            new ConcreteInterfaceMethodParameter('');

        } catch (ParameterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsParameterException() {

        $asserted = false;
        try {

            new ConcreteInterfaceMethodParameter(new \DateTime());

        } catch (ParameterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
