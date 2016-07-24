<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Tests\Inputs\Helpers\Objects\CodeHelper;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteCodeMethod;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Exceptions\MethodException;

final class ConcreteCodeMethodAdapterTest extends \PHPUnit_Framework_TestCase {
    private $codeMock;
    private $className;
    private $methodName;
    private $codeHelper;
    public function setUp() {
        $this->codeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Code');

        $this->className = 'iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects\ConcreteCodeMethodAdapterTest';
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

    public function testCreate_withEmptyMethodName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteCodeMethod($this->codeMock, '');

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringMethodName_throwsMethodException() {

        $asserted = false;
        try {

            new ConcreteCodeMethod($this->codeMock, '');

        } catch (MethodException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
