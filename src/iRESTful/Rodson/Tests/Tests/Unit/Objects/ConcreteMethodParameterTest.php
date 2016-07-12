<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethodParameter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteMethodParameterTest extends \PHPUnit_Framework_TestCase {
    private $interfaceMock;
    private $name;
    public function setUp() {
        $this->interfaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Methods\Returns\ReturnedInterface');
        $this->name = 'myName';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $parameter = new ConcreteMethodParameter($this->name);

        $this->assertEquals($this->name, $parameter->getName());
        $this->assertFalse($parameter->hasReturnedInterface());
        $this->assertNull($parameter->getReturnedInterface());

    }

    public function testCreate_withInterface_Success() {

        $parameter = new ConcreteMethodParameter($this->name, $this->interfaceMock);

        $this->assertEquals($this->name, $parameter->getName());
        $this->assertTrue($parameter->hasReturnedInterface());
        $this->assertEquals($this->interfaceMock, $parameter->getReturnedInterface());

    }

    public function testCreate_withEmptyName_throwsParameterException() {

        $asserted = false;
        try {

            new ConcreteMethodParameter('');

        } catch (ParameterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsParameterException() {

        $asserted = false;
        try {

            new ConcreteMethodParameter(new \DateTime());

        } catch (ParameterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
