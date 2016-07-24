<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteCodeMethodAdapter;
use iRESTful\Rodson\Tests\Inputs\Helpers\Objects\CodeHelper;

final class ConcreteCodeMethodAdapterTest extends \PHPUnit_Framework_TestCase {
    private $codeMock;
    private $className;
    private $methodName;
    private $adapter;
    private $codeHelper;
    public function setUp() {
        $this->codeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Code');

        $this->className = 'iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters\ConcreteCodeMethodAdapterTest';
        $this->methodName = 'setUp';

        $this->adapter = new ConcreteCodeMethodAdapter($this->codeMock);

        $this->codeHelper = new CodeHelper($this, $this->codeMock);
    }

    public function tearDown() {

    }

    public function testFromStringToMethod_Success() {

        $this->codeHelper->expectsGetClassName_Success($this->className);

        $method = $this->adapter->fromStringToMethod($this->methodName);

        $this->assertEquals($this->codeMock, $method->getCode());
        $this->assertEquals($this->methodName, $method->getMethodName());

    }

}
