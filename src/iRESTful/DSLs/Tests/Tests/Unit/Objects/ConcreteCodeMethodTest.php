<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Tests\Helpers\Objects\CodeHelper;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteCodeMethod;
use iRESTful\DSLs\Domain\Projects\Codes\Methods\Exceptions\MethodException;

final class ConcreteCodeMethodTest extends \PHPUnit_Framework_TestCase {
    private $codeMock;
    private $className;
    private $methodName;
    private $codeHelper;
    public function setUp() {
        $this->codeMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Codes\Code');

        $this->className = 'iRESTful\DSLs\Tests\Tests\Unit\Objects\ConcreteCodeMethodTest';
        $this->methodName = 'setUp';

        $this->codeHelper = new CodeHelper($this, $this->codeMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->codeHelper->expectsGetClassName_Success($this->className);

        $method = new ConcreteCodeMethod($this->codeMock, $this->methodName);

        $this->assertEquals($this->codeMock, $method->getCode());
        $this->assertEquals($this->methodName, $method->getMethodName());

    }

    public function testCreate_withInvalidMethodName_throwsMethodException() {

        $this->codeHelper->expectsGetClassName_Success($this->className);

        $asserted = false;
        try {

            new ConcreteCodeMethod($this->codeMock, 'invalidMethodName');

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
