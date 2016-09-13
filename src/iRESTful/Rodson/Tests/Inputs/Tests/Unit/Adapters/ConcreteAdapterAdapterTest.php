<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteAdapterAdapter;
use iRESTful\Rodson\Tests\Inputs\Helpers\Adapters\MethodAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Exceptions\ConverterException;

final class ConcreteAdapterAdapterTest extends \PHPUnit_Framework_TestCase {
    private $methodAdapterMock;
    private $methodMock;
    private $typeMock;
    private $methodName;
    private $types;
    private $data;
    private $adapter;
    private $methodAdapterHelper;
    public function setUp() {
        $this->methodAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Adapters\MethodAdapter');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Method');
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Types\Type');

        $this->methodName = 'myMethod';

        $this->types = [
            'string' => $this->typeMock,
            'base_url' => $this->typeMock
        ];

        $this->data = [
            'from' => 'string',
            'to' => 'base_url',
            'method' => $this->methodName
        ];

        $this->adapter = new ConcreteAdapterAdapter($this->methodAdapterMock, $this->types);

        $this->methodAdapterHelper = new MethodAdapterHelper($this, $this->methodAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToConverter_Success() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $adapter = $this->adapter->fromDataToConverter($this->data);

        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertEquals($this->typeMock, $adapter->toType());
        $this->assertEquals($this->methodMock, $adapter->getMethod());

    }

    public function testFromDataToConverter_withFromNameNotFoundInTypes_Success() {

        $this->data['from'] = 'invalid';

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $adapter = $this->adapter->fromDataToConverter($this->data);

        $this->assertFalse($adapter->hasFromType());
        $this->assertNull($adapter->fromType());
        $this->assertTrue($adapter->hasToType());
        $this->assertEquals($this->typeMock, $adapter->toType());
        $this->assertEquals($this->methodMock, $adapter->getMethod());

    }

    public function testFromDataToConverter_withoutFromType_Success() {

        unset($this->data['from']);

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $adapter = $this->adapter->fromDataToConverter($this->data);

        $this->assertFalse($adapter->hasFromType());
        $this->assertNull($adapter->fromType());
        $this->assertTrue($adapter->hasToType());
        $this->assertEquals($this->typeMock, $adapter->toType());
        $this->assertEquals($this->methodMock, $adapter->getMethod());

    }

    public function testFromDataToConverter_withToNameNotFoundInTypes_Success() {

        $this->data['to'] = 'invalid';

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $adapter = $this->adapter->fromDataToConverter($this->data);

        $this->assertTrue($adapter->hasFromType());
        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertFalse($adapter->hasToType());
        $this->assertNull($adapter->toType());
        $this->assertEquals($this->methodMock, $adapter->getMethod());

    }

    public function testFromDataToConverter_withoutToType_Success() {

        unset($this->data['to']);

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $adapter = $this->adapter->fromDataToConverter($this->data);

        $this->assertTrue($adapter->hasFromType());
        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertFalse($adapter->hasToType());
        $this->assertNull($adapter->toType());
        $this->assertEquals($this->methodMock, $adapter->getMethod());

    }

    public function testFromDataToConverter_throwsMethodException_throwsConverterException() {

        $this->methodAdapterHelper->expectsFromStringToMethod_throwsMethodException($this->methodName);

        $asserted = false;
        try {

            $this->adapter->fromDataToConverter($this->data);

        } catch (ConverterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToConverter_withoutMethod_throwsConverterException() {

        unset($this->data['method']);

        $asserted = false;
        try {

            $this->adapter->fromDataToConverter($this->data);

        } catch (ConverterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToConverters_Success() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $adapters = $this->adapter->fromDataToConverters([$this->data]);

        $keyname = 'from_'.$this->data['from'].'_to_'.$this->data['to'];
        $this->assertEquals($this->typeMock, $adapters[$keyname]->fromType());
        $this->assertEquals($this->typeMock, $adapters[$keyname]->toType());
        $this->assertEquals($this->methodMock, $adapters[$keyname]->getMethod());

    }

}
