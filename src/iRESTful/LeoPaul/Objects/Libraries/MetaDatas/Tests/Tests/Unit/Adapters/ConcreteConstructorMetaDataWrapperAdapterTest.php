<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteConstructorMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConcreteConstructorMetaDataWrapperAdapterTest extends \PHPUnit_Framework_TestCase {
	private $argumentMetaDataWrapperAdapterMock;
	private $transformerWrapperAdapterMock;
	private $constructorMetaDataMock;
	private $objectAdapterMock;
	private $delimiter;
	private $className;
	private $data;
	private $dataWithCallbackOnFail;
	private $adapter;
	public function setUp() {
		$this->argumentMetaDataWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\Adapters\ArgumentMetaDataWrapperAdapter');
		$this->transformerWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter');
		$this->constructorMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData');
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');

		$this->delimiter = '___';
		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters\ConcreteConstructorMetaDataWrapperAdapterTest';

		$this->data = [
			'constructor_meta_data' => $this->constructorMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className
		];

		$this->dataWithCallbackOnFail = [
			'constructor_meta_data' => $this->constructorMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => function() {

			}
		];

		$this->adapter = new ConcreteConstructorMetaDataWrapperAdapter($this->argumentMetaDataWrapperAdapterMock, $this->transformerWrapperAdapterMock, $this->delimiter);
	}

	public function tearDown() {

	}

	public function testFromDataToConstructorMetaDataWrapper_Success() {

		$constructorMetaDataWrapper = $this->adapter->fromDataToConstructorMetaDataWrapper($this->data);

		$this->assertTrue($constructorMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\ConstructorMetaDataWrapper);

	}

	public function testFromDataToConstructorMetaDataWrapper_withoutConstructorMetaData_Success() {

		$asserted = false;
		try {

			unset($this->data['constructor_meta_data']);
			$this->adapter->fromDataToConstructorMetaDataWrapper($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaDataWrapper_withoutObjectAdapter_Success() {

		$asserted = false;
		try {

			unset($this->data['object_adapter']);
			$this->adapter->fromDataToConstructorMetaDataWrapper($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaDataWrapper_withoutClass_Success() {

		$asserted = false;
		try {

			unset($this->data['class']);
			$this->adapter->fromDataToConstructorMetaDataWrapper($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToConstructorMetaDataWrapper_withCallbackOnFail_Success() {

		$constructorMetaDataWrapper = $this->adapter->fromDataToConstructorMetaDataWrapper($this->dataWithCallbackOnFail);

		$this->assertTrue($constructorMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\ConstructorMetaDataWrapper);

	}

}
