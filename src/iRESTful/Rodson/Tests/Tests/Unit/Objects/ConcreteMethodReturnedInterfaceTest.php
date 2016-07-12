<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethodReturnedInterface;

final class ConcreteMethodReturnedInterfaceTest extends \PHPUnit_Framework_TestCase {
    private $namespaceMock;
    private $name;
    public function setUp() {
        $this->namespaceMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace');

        $this->name = 'MyName';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $returnedInterface = new ConcreteMethodReturnedInterface($this->name, $this->namespaceMock);

        $this->assertEquals($this->name, $returnedInterface->getName());
        $this->assertEquals($this->namespaceMock, $returnedInterface->getNamespace());

    }

    public function testCreate_withEmptyName_throwsReturnedInterfaceException() {

        $asserted = false;
        try {

            new ConcreteMethodReturnedInterface('', $this->namespaceMock);

        } catch (ReturnedInterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsReturnedInterfaceException() {

        $asserted = false;
        try {

            new ConcreteMethodReturnedInterface(new \DateTime(), $this->namespaceMock);

        } catch (ReturnedInterfaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
