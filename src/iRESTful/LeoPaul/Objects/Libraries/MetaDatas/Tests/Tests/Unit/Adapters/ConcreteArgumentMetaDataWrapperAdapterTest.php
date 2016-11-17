<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArgumentMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ConcreteArgumentMetaDataWrapperAdapterTest extends \PHPUnit_Framework_TestCase {
	private $arrayMetaDataWrapperAdapterMock;
	private $argumentMetaDataMock;
	private $objectAdapterMock;
	private $className;
	private $data;
	private $dataWithCallbackOnFail;
	private $adapter;
	public function setUp() {
		$this->arrayMetaDataWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\Adapters\ArrayMetaDataWrapperAdapter');
		$this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');

		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters\ConcreteArgumentMetaDataWrapperAdapterTest';

		$this->data = [
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className
		];

		$this->dataWithCallbackOnFail = [
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => function() {

			}
		];

		$this->adapter = new ConcreteArgumentMetaDataWrapperAdapter($this->arrayMetaDataWrapperAdapterMock);
	}

	public function tearDown() {

	}

	public function testFromDataToArgumentMetaDataWrapper_Success() {

		$argumentMetaDataWrapper = $this->adapter->fromDataToArgumentMetaDataWrapper($this->data);

		$this->assertTrue($argumentMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper);

	}

	public function testFromDataToArgumentMetaDataWrapper_withCallbackOnFail_Success() {

		$argumentMetaDataWrapper = $this->adapter->fromDataToArgumentMetaDataWrapper($this->dataWithCallbackOnFail);

		$this->assertTrue($argumentMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper);

	}

	public function testFromDataToArgumentMetaDataWrapper_withoutArgumentMetaData_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['argument_meta_data']);
			$this->adapter->fromDataToArgumentMetaDataWrapper($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToArgumentMetaDataWrapper_withoutObjectAdapter_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['object_adapter']);
			$this->adapter->fromDataToArgumentMetaDataWrapper($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToArgumentMetaDataWrapper_withoutClass_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['class']);
			$this->adapter->fromDataToArgumentMetaDataWrapper($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
