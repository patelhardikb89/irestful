<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteConstructorMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ArgumentMetaDataAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\TransformerAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\TypeAdapterHelper;

final class ConcreteConstructorMetaDataAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeAdapterMock;
    private $typeMock;
	private $argumentMetaDataAdapterMock;
	private $argumentMetaDataMock;
	private $transformerAdapterMock;
	private $transformerMock;
	private $classMetaDataMock;
	private $argumentMetaData;
	private $transformerData;
    private $typeData;
	private $data;
    private $dataWithTransformer;
    private $dataWithHumanMethodName;
    private $dataWithHumanMethodNameWithTransformer;
    private $dataWithType;
	private $adapter;
    private $typeAdapterHelper;
	private $argumentMetaDataAdapterHelper;
	private $transformerAdapterHelper;
	public function setUp() {
        $this->typeAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Adapters\TypeAdapter');
        $this->typeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type');
		$this->argumentMetaDataAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Adapters\ArgumentMetaDataAdapter');
		$this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
		$this->transformerAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters\TransformerAdapter');
		$this->transformerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer');
		$this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');

		$this->argumentMetaData = [
			'some' => 'argument_data'
		];

		$this->transformerData = [
			'some' => 'transformer_data'
		];

        $this->typeData = [
            'some' => 'type_data'
        ];

		$this->data = [
			'argument_meta_data' => $this->argumentMetaData,
			'method_name' => 'myMethod',
			'keyname' => 'my_keyname'
		];

		$this->dataWithTransformer = [
			'argument_meta_data' => $this->argumentMetaData,
			'method_name' => 'myMethod',
			'keyname' => 'my_keyname',
			'transformer' => $this->transformerData
		];

		$this->dataWithHumanMethodName = [
			'argument_meta_data' => $this->argumentMetaData,
			'method_name' => 'myMethod',
			'keyname' => 'my_keyname',
			'human_method_name' => 'myHumanMethod'
		];

		$this->dataWithHumanMethodNameWithTransformer = [
			'argument_meta_data' => $this->argumentMetaData,
			'method_name' => 'myMethod',
			'keyname' => 'my_keyname',
			'human_method_name' => 'myHumanMethod',
			'transformer' => $this->transformerData
		];

        $this->dataWithType = [
			'argument_meta_data' => $this->argumentMetaData,
			'method_name' => 'myMethod',
			'keyname' => 'my_keyname',
            'type' => $this->typeData
		];

		$this->adapter = new ConcreteConstructorMetaDataAdapter($this->typeAdapterMock, $this->argumentMetaDataAdapterMock, $this->transformerAdapterMock);

        $this->typeAdapterHelper = new TypeAdapterHelper($this, $this->typeAdapterMock);
		$this->argumentMetaDataAdapterHelper = new ArgumentMetaDataAdapterHelper($this, $this->argumentMetaDataAdapterMock);
		$this->transformerAdapterHelper = new TransformerAdapterHelper($this, $this->transformerAdapterMock);
	}

	public function tearDown() {

	}

    public function testFromDataToConstructorMetaData_Success() {

		$this->argumentMetaDataAdapterHelper->expectsFromDataToArgumentMetaData_Success($this->argumentMetaDataMock, $this->argumentMetaData);

		$constructorMetaData = $this->adapter->fromDataToConstructorMetaData($this->data);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
		$this->assertEquals($this->data['method_name'], $constructorMetaData->getMethodName());
		$this->assertEquals($this->data['keyname'], $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertFalse($constructorMetaData->hasType());
        $this->assertNull($constructorMetaData->getType());
	}

    public function testFromDataToConstructorMetaData_withType_Success() {

        $this->typeAdapterHelper->expectsFromDataToType_Success($this->typeMock, $this->typeData);
		$this->argumentMetaDataAdapterHelper->expectsFromDataToArgumentMetaData_Success($this->argumentMetaDataMock, $this->argumentMetaData);

		$constructorMetaData = $this->adapter->fromDataToConstructorMetaData($this->dataWithType);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
		$this->assertEquals($this->data['method_name'], $constructorMetaData->getMethodName());
		$this->assertEquals($this->data['keyname'], $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertTrue($constructorMetaData->hasType());
        $this->assertEquals($this->typeMock, $constructorMetaData->getType());
	}

	public function testFromDataToConstructorMetaData_withTransformerData_Success() {

		$this->transformerAdapterHelper->expectsFromDataToTransformer_Success($this->transformerMock, $this->transformerData);
		$this->argumentMetaDataAdapterHelper->expectsFromDataToArgumentMetaData_Success($this->argumentMetaDataMock, $this->argumentMetaData);

		$constructorMetaData = $this->adapter->fromDataToConstructorMetaData($this->dataWithTransformer);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
		$this->assertEquals($this->dataWithTransformer['method_name'], $constructorMetaData->getMethodName());
		$this->assertEquals($this->dataWithTransformer['keyname'], $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertTrue($constructorMetaData->hasTransformer());
		$this->assertEquals($this->transformerMock, $constructorMetaData->getTransformer());
        $this->assertFalse($constructorMetaData->hasType());
        $this->assertNull($constructorMetaData->getType());

	}

	public function testFromDataToConstructorMetaData_withHumanMethodName_Success() {

		$this->argumentMetaDataAdapterHelper->expectsFromDataToArgumentMetaData_Success($this->argumentMetaDataMock, $this->argumentMetaData);

		$constructorMetaData = $this->adapter->fromDataToConstructorMetaData($this->dataWithHumanMethodName);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
		$this->assertEquals($this->dataWithHumanMethodName['method_name'], $constructorMetaData->getMethodName());
		$this->assertEquals($this->dataWithHumanMethodName['keyname'], $constructorMetaData->getKeyname());
		$this->assertTrue($constructorMetaData->hasHumanMethodName());
		$this->assertEquals($this->dataWithHumanMethodName['human_method_name'], $constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertFalse($constructorMetaData->hasType());
        $this->assertNull($constructorMetaData->getType());

	}

	public function testFromDataToConstructorMetaData_withTransformerData_withHumanMethodName_Success() {

		$this->transformerAdapterHelper->expectsFromDataToTransformer_Success($this->transformerMock, $this->transformerData);
		$this->argumentMetaDataAdapterHelper->expectsFromDataToArgumentMetaData_Success($this->argumentMetaDataMock, $this->argumentMetaData);

		$constructorMetaData = $this->adapter->fromDataToConstructorMetaData($this->dataWithHumanMethodNameWithTransformer);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
		$this->assertEquals($this->dataWithHumanMethodNameWithTransformer['method_name'], $constructorMetaData->getMethodName());
		$this->assertEquals($this->dataWithHumanMethodNameWithTransformer['keyname'], $constructorMetaData->getKeyname());
		$this->assertTrue($constructorMetaData->hasHumanMethodName());
		$this->assertEquals($this->dataWithHumanMethodNameWithTransformer['human_method_name'], $constructorMetaData->getHumanMethodName());
		$this->assertTrue($constructorMetaData->hasTransformer());
		$this->assertEquals($this->transformerMock, $constructorMetaData->getTransformer());
        $this->assertFalse($constructorMetaData->hasType());
        $this->assertNull($constructorMetaData->getType());

	}

	public function testFromDataToConstructorMetaData_withTransformerData_withHumanMethodName_throwsArgumentMetaDataException_throwsConstructorMetaDataException() {

		$this->transformerAdapterHelper->expectsFromDataToTransformer_Success($this->transformerMock, $this->transformerData);
		$this->argumentMetaDataAdapterHelper->expectsFromDataToArgumentMetaData_throwsArgumentMetaDataException($this->argumentMetaData);

		$asserted = false;
		try {

			$this->adapter->fromDataToConstructorMetaData($this->dataWithHumanMethodNameWithTransformer);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaData_withTransformerData_withHumanMethodName_throwsTransformerException_throwsConstructorMetaDataException() {

		$this->transformerAdapterHelper->expectsFromDataToTransformer_throwsTransformerException($this->transformerData);

		$asserted = false;
		try {

			$this->adapter->fromDataToConstructorMetaData($this->dataWithHumanMethodNameWithTransformer);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaData_withoutArgumentMetaData_throwsConstructorMetaDataException() {

		unset($this->data['argument_meta_data']);

		$asserted = false;
		try {

			$this->adapter->fromDataToConstructorMetaData($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaData_withoutMethodName_throwsConstructorMetaDataException() {

		unset($this->data['method_name']);

		$asserted = false;
		try {

			$this->adapter->fromDataToConstructorMetaData($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaData_withoutKeyname_throwsConstructorMetaDataException() {

		unset($this->data['keyname']);

		$asserted = false;
		try {

			$this->adapter->fromDataToConstructorMetaData($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

    public function testFromDataToConstructorMetaData_withType_throwsTypeException() {

		$this->typeAdapterHelper->expectsFromDataToType_throwsTypeException($this->typeData);

        $asserted = false;
		try {

			$this->adapter->fromDataToConstructorMetaData($this->dataWithType);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

}
