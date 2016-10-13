<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteObjectMethod;
use iRESTful\DSLs\Domain\Projects\Objects\Methods\Exceptions\MethodException;

final class ConcreteObjectMethodTest extends \PHPUnit_Framework_TestCase {
    private $methodMock;
    private $name;
    public function setUp() {
        $this->methodMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Codes\Methods\Method');

        $this->name = 'my_method';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $method = new ConcreteObjectMethod($this->name, $this->methodMock);

        $this->assertEquals($this->name, $method->getName());
        $this->assertEquals($this->methodMock, $method->getMethod());

    }

    public function testCreate_withEmptyName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteObjectMethod('', $this->methodMock);

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
