<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteClassMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ConstructorMetaDataAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ConcreteClassMetaDataAdapterTest extends \PHPUnit_Framework_TestCase {
	private $constructorMetaDataAdapterMock;
	private $constructorMetaDataMock;
	private $constructorMetaDataMocks;
	private $argumentsData;
	private $data;
	private $dataWithContainerName;
	private $adapter;
	private $constructorMetaDataAdapterHelper;
	public function setUp() {

		$this->constructorMetaDataAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Adapters\ConstructorMetaDataAdapter');
		$this->constructorMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData');

		$this->constructorMetaDataMocks = [
			'first' => $this->constructorMetaDataMock,
			'second' => $this->constructorMetaDataMock
		];

		$this->argumentsData = [
			'first' => ['one' => 'argument'],
			'second' => ['second' => 'argument']
		];

		$this->data = [
			'class' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters\ConcreteClassMetaDataAdapterTest',
			'arguments' => $this->argumentsData
		];

		$this->dataWithContainerName = [
			'class' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters\ConcreteClassMetaDataAdapterTest',
			'container_name' => 'my_container',
			'arguments' => $this->argumentsData
		];

		$this->adapter = new ConcreteClassMetaDataAdapter($this->constructorMetaDataAdapterMock);

		$this->constructorMetaDataAdapterHelper = new ConstructorMetaDataAdapterHelper($this, $this->constructorMetaDataAdapterMock);
	}

	public function tearDown() {

	}

	public function testFromDataToClassMetaData_Success() {

		$this->constructorMetaDataAdapterHelper->expectsFromDataToConstructorMetaDatas_Success($this->constructorMetaDataMocks, $this->argumentsData);

		$classMetaData = $this->adapter->fromDataToClassMetaData($this->data);

		$this->assertFalse($classMetaData->hasContainerName());
		$this->assertNull($classMetaData->getContainerName());
		$this->assertEquals($this->constructorMetaDataMocks, $classMetaData->getArguments());

	}

	public function testFromDataToClassMetaData_throwsConstructorMetaDataException_throwsClassMetaDataException() {

		$this->constructorMetaDataAdapterHelper->expectsFromDataToConstructorMetaDatas_throwsConstructorMetaDataException($this->argumentsData);

		$asserted = false;
		try {

			$this->adapter->fromDataToClassMetaData($this->data);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToClassMetaData_withoutClassName_throwsClassMetaDataException() {

		unset($this->data['class']);

		$asserted = false;
		try {

			$this->adapter->fromDataToClassMetaData($this->data);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToClassMetaData_withoutArguments_throwsClassMetaDataException() {

		unset($this->data['arguments']);

		$asserted = false;
		try {

			$this->adapter->fromDataToClassMetaData($this->data);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToClassMetaData_withContainerName_Success() {

		$this->constructorMetaDataAdapterHelper->expectsFromDataToConstructorMetaDatas_Success($this->constructorMetaDataMocks, $this->argumentsData);

		$classMetaData = $this->adapter->fromDataToClassMetaData($this->dataWithContainerName);

		$this->assertTrue($classMetaData->hasContainerName());
		$this->assertEquals($this->dataWithContainerName['container_name'], $classMetaData->getContainerName());
		$this->assertEquals($this->constructorMetaDataMocks, $classMetaData->getArguments());

	}

}
