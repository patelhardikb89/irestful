<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteClassMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ConcreteClassMetaDataWrapperAdapterTest extends \PHPUnit_Framework_TestCase {
	private $constructorMetaDataWrapperAdapterMock;
	private $classMetaDataMock;
	private $objectAdapterMock;
	private $className;
	private $data;
	private $dataWithCallbackOnFail;
	private $adapter;
	public function setUp() {
		$this->constructorMetaDataWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\Adapters\ConstructorMetaDataWrapperAdapter');
		$this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');

		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters\ConcreteClassMetaDataWrapperAdapterTest';

		$this->data = [
			'class_meta_data' => $this->classMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className
		];

		$this->dataWithCallbackOnFail = [
			'class_meta_data' => $this->classMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => function() {

			}
		];

		$this->adapter = new ConcreteClassMetaDataWrapperAdapter($this->constructorMetaDataWrapperAdapterMock);

	}

	public function tearDown() {

	}

	public function testFromDataToClassMetaDataWrapper_Success() {

		$classMetaDataWrapper = $this->adapter->fromDataToClassMetaDataWrapper($this->data);

		$this->assertTrue($classMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Wrappers\ClassMetaDataWrapper);

	}

	public function testFromDataToClassMetaDataWrapper_withoutClassMetaData_throwsClassMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['class_meta_data']);
			$this->adapter->fromDataToClassMetaDataWrapper($this->data);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToClassMetaDataWrapper_withoutObjectAdapter_throwsClassMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['object_adapter']);
			$this->adapter->fromDataToClassMetaDataWrapper($this->data);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToClassMetaDataWrapper_withoutClass_throwsClassMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['class']);
			$this->adapter->fromDataToClassMetaDataWrapper($this->data);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToClassMetaDataWrapper_withCallbackOnFail_Success() {

		$classMetaDataWrapper = $this->adapter->fromDataToClassMetaDataWrapper($this->dataWithCallbackOnFail);

		$this->assertTrue($classMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Wrappers\ClassMetaDataWrapper);

	}

}
