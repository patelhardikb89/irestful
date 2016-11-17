<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArgumentMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ArrayMetaDataAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ConcreteArgumentMetaDataAdapterTest extends \PHPUnit_Framework_TestCase {
	private $arrayMetaDataAdapterMock;
	private $arrayMetaDataMock;
	private $classMetaDataMock;
	private $arrayMetaDataData;
	private $data;
	private $adapter;
	private $arrayMetaDataAdapterHelper;
	public function setUp() {
		$this->arrayMetaDataAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Adapters\ArrayMetaDataAdapter');
		$this->arrayMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData');
		$this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');

		$this->arrayMetaDataData = [
			'one' => 'array meta data'
		];

		$this->data = [
			'name' => 'myArgument',
			'position' => rand(0, 100),
			'is_optional' => false
		];

		$this->dataWithClassMetaData = [
			'name' => 'myArgument',
			'position' => rand(0, 100),
			'is_optional' => false,
			'class_meta_data' => $this->classMetaDataMock
		];

		$this->dataWithIsOptional = [
			'name' => 'myArgument',
			'position' => rand(0, 100),
			'is_optional' => true
		];

		$this->dataWithIsRecursive = [
			'name' => 'myArgument',
			'position' => rand(0, 100),
			'is_optional' => false,
			'is_recursive' => true
		];

		$this->dataWithArrayMetaData = [
			'name' => 'myArgument',
			'position' => rand(0, 100),
			'is_optional' => false,
			'array_meta_data' => $this->arrayMetaDataData
		];

		$this->adapter = new ConcreteArgumentMetaDataAdapter($this->arrayMetaDataAdapterMock);

		$this->arrayMetaDataAdapterHelper = new ArrayMetaDataAdapterHelper($this, $this->arrayMetaDataAdapterMock);
	}

	public function tearDown() {

	}

	public function testFromDataToArgumentMetaData_Success() {

		$argumentMetaData = $this->adapter->fromDataToArgumentMetaData($this->data);

		$this->assertEquals($this->data['name'], $argumentMetaData->getName());
		$this->assertEquals($this->data['position'], $argumentMetaData->getPosition());
		$this->assertFalse($argumentMetaData->hasClassMetaData());
		$this->assertNull($argumentMetaData->getClassMetaData());
		$this->assertFalse($argumentMetaData->isOptional());
		$this->assertFalse($argumentMetaData->isRecursive());
		$this->assertFalse($argumentMetaData->hasArrayMetaData());
		$this->assertNull($argumentMetaData->getArrayMetaData());
	}

	public function testFromDataToArgumentMetaData_withClassMetaData_Success() {

		$argumentMetaData = $this->adapter->fromDataToArgumentMetaData($this->dataWithClassMetaData);

		$this->assertEquals($this->dataWithClassMetaData['name'], $argumentMetaData->getName());
		$this->assertEquals($this->dataWithClassMetaData['position'], $argumentMetaData->getPosition());
		$this->assertTrue($argumentMetaData->hasClassMetaData());
		$this->assertEquals($this->classMetaDataMock, $argumentMetaData->getClassMetaData());
		$this->assertFalse($argumentMetaData->isOptional());
		$this->assertFalse($argumentMetaData->isRecursive());
		$this->assertFalse($argumentMetaData->hasArrayMetaData());
		$this->assertNull($argumentMetaData->getArrayMetaData());
	}

	public function testFromDataToArgumentMetaData_isOptional_Success() {

		$argumentMetaData = $this->adapter->fromDataToArgumentMetaData($this->dataWithIsOptional);

		$this->assertEquals($this->dataWithIsOptional['name'], $argumentMetaData->getName());
		$this->assertEquals($this->dataWithIsOptional['position'], $argumentMetaData->getPosition());
		$this->assertFalse($argumentMetaData->hasClassMetaData());
		$this->assertNull($argumentMetaData->getClassMetaData());
		$this->assertTrue($argumentMetaData->isOptional());
		$this->assertFalse($argumentMetaData->isRecursive());
		$this->assertFalse($argumentMetaData->hasArrayMetaData());
		$this->assertNull($argumentMetaData->getArrayMetaData());
	}

	public function testFromDataToArgumentMetaData_isRecursive_Success() {

		$argumentMetaData = $this->adapter->fromDataToArgumentMetaData($this->dataWithIsRecursive);

		$this->assertEquals($this->dataWithIsRecursive['name'], $argumentMetaData->getName());
		$this->assertEquals($this->dataWithIsRecursive['position'], $argumentMetaData->getPosition());
		$this->assertFalse($argumentMetaData->hasClassMetaData());
		$this->assertNull($argumentMetaData->getClassMetaData());
		$this->assertFalse($argumentMetaData->isOptional());
		$this->assertTrue($argumentMetaData->isRecursive());
		$this->assertFalse($argumentMetaData->hasArrayMetaData());
		$this->assertNull($argumentMetaData->getArrayMetaData());
	}

	public function testFromDataToArgumentMetaData_withArrayMetaData_Success() {

		$this->arrayMetaDataAdapterHelper->expectsFromDataToArrayMetaData_Success($this->arrayMetaDataMock, $this->arrayMetaDataData);

		$argumentMetaData = $this->adapter->fromDataToArgumentMetaData($this->dataWithArrayMetaData);

		$this->assertEquals($this->dataWithArrayMetaData['name'], $argumentMetaData->getName());
		$this->assertEquals($this->dataWithArrayMetaData['position'], $argumentMetaData->getPosition());
		$this->assertFalse($argumentMetaData->hasClassMetaData());
		$this->assertNull($argumentMetaData->getClassMetaData());
		$this->assertFalse($argumentMetaData->isOptional());
		$this->assertFalse($argumentMetaData->isRecursive());
		$this->assertTrue($argumentMetaData->hasArrayMetaData());
		$this->assertEquals($this->arrayMetaDataMock, $argumentMetaData->getArrayMetaData());
	}

	public function testFromDataToArgumentMetaData_withArrayMetaData_throwsArrayMetaDataException_throwsArgumentMetaDataException() {

		$this->arrayMetaDataAdapterHelper->expectsfFromDataToArrayMetaData_throwsArrayMetaDataException($this->arrayMetaDataData);

		$asserted = false;
		try {

			$this->adapter->fromDataToArgumentMetaData($this->dataWithArrayMetaData);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testFromDataToArgumentMetaData_withoutName_throwsArgumentMetaDataException() {

		unset($this->data['name']);

		$asserted = false;
		try {

			$this->adapter->fromDataToArgumentMetaData($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testFromDataToArgumentMetaData_withoutPosition_throwsArgumentMetaDataException() {

		unset($this->data['position']);

		$asserted = false;
		try {

			$this->adapter->fromDataToArgumentMetaData($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

}
