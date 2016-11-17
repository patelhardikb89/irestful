<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteConstructorMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers\ArgumentMetaDataWrapperHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ArgumentMetaDataWrapperAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\TransformerWrapperAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers\TransformerWrapperHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ConstructorMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ArgumentMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConcreteConstructorMetaDataWrapperTest extends \PHPUnit_Framework_TestCase {
	private $objectAdapterMock;
	private $argumentMetaDataWrapperAdapterMock;
	private $argumentMetaDataWrapperMock;
	private $argumentMetaDataMock;
	private $transformerWrapperAdapterMock;
	private $transformerWrapperMock;
	private $constructorMetaDataMock;
	private $className;
	private $delimiter;
	private $callBackOnFail;
	private $keyname;
	private $normalizedKeyname;
	private $transformedValue;
	private $data;
	private $dataWithNormalizedData;
	private $subData;
	private $wrapper;
	private $wrapperWithCallbackOnFail;
	private $argumentMetaDataWrapperAdapterHelper;
	private $argumentMetaDataWrapperHelper;
	private $argumentMetaDataHelper;
	private $transformerWrapperAdapterHelper;
	private $transformerWrapperHelper;
	private $constructorMetaDataHelper;
	public function setUp() {
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');
		$this->argumentMetaDataWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\Adapters\ArgumentMetaDataWrapperAdapter');
		$this->argumentMetaDataWrapperMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper');
		$this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
		$this->transformerWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter');
		$this->transformerWrapperMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\TransformerWrapper');
		$this->transformerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer');
		$this->constructorMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData');

		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Wrappers\ConcreteConstructorMetaDataWrapperTest';
		$this->delimiter = '___';
		$this->callBackOnFail = function() {

		};

		$this->keyname = 'some_keyname';
		$this->transformedValue = 'this is a transformed value.';

		$this->data = [
			$this->keyname => 'data'
		];

		$this->normalizedKeyname = 'first';
		$this->dataWithNormalizedData = [
			$this->normalizedKeyname.$this->delimiter.$this->keyname => 'data',
			'another' => 'keyname'
		];

		$this->subData = [
			$this->keyname => 'data'
		];

		$this->wrapper = new ConcreteConstructorMetaDataWrapper($this->objectAdapterMock, $this->argumentMetaDataWrapperAdapterMock, $this->transformerWrapperAdapterMock, $this->constructorMetaDataMock, $this->className, $this->delimiter);
		$this->wrapperWithCallbackOnFail = new ConcreteConstructorMetaDataWrapper($this->objectAdapterMock, $this->argumentMetaDataWrapperAdapterMock, $this->transformerWrapperAdapterMock, $this->constructorMetaDataMock, $this->className, $this->delimiter, $this->callBackOnFail);

		$this->argumentMetaDataWrapperAdapterHelper = new ArgumentMetaDataWrapperAdapterHelper($this, $this->argumentMetaDataWrapperAdapterMock);
		$this->argumentMetaDataWrapperHelper = new ArgumentMetaDataWrapperHelper($this, $this->argumentMetaDataWrapperMock);
		$this->argumentMetaDataHelper = new ArgumentMetaDataHelper($this, $this->argumentMetaDataMock);
		$this->transformerWrapperAdapterHelper = new TransformerWrapperAdapterHelper($this, $this->transformerWrapperAdapterMock);
		$this->transformerWrapperHelper = new TransformerWrapperHelper($this, $this->transformerWrapperMock);
		$this->constructorMetaDataHelper = new ConstructorMetaDataHelper($this, $this->constructorMetaDataMock);
	}

	public function tearDown() {

	}

	public function testTransform_Success() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->keyname);
		$this->argumentMetaDataWrapperAdapterHelper->expectsFromDataToArgumentMetaDataWrapper_Success($this->argumentMetaDataWrapperMock, [
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => null
		]);

		$this->argumentMetaDataWrapperHelper->expectsTransform_Success($this->transformedValue, $this->data[$this->keyname]);

		$transformedValue = $this->wrapper->transform($this->data);

		$this->assertEquals($this->transformedValue, $transformedValue);

	}

	public function testTransform_withCallbackOnFail_Success() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->keyname);
		$this->argumentMetaDataWrapperAdapterHelper->expectsFromDataToArgumentMetaDataWrapper_Success($this->argumentMetaDataWrapperMock, [
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => $this->callBackOnFail
		]);

		$this->argumentMetaDataWrapperHelper->expectsTransform_Success($this->transformedValue, $this->data[$this->keyname]);

		$transformedValue = $this->wrapperWithCallbackOnFail->transform($this->data);

		$this->assertEquals($this->transformedValue, $transformedValue);

	}

	public function testTransform_throwsArgumentMetaDataException_whileTransforming_throwsConstructorMetaDataException() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->keyname);
		$this->constructorMetaDataHelper->expectsHasTransformer_Success(false);
		$this->argumentMetaDataWrapperAdapterHelper->expectsFromDataToArgumentMetaDataWrapper_Success($this->argumentMetaDataWrapperMock, [
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => null
		]);

		$this->argumentMetaDataWrapperHelper->expectsTransform_throwsArgumentMetaDataException($this->data[$this->keyname]);

		$asserted = false;
		try {

			$this->wrapper->transform($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_throwsArgumentMetaDataException_throwsConstructorMetaDataException() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->keyname);
		$this->constructorMetaDataHelper->expectsHasTransformer_Success(false);
		$this->argumentMetaDataWrapperAdapterHelper->expectsFromDataToArgumentMetaDataWrapper_throwsArgumentMetaDataException([
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => null
		]);

		$asserted = false;
		try {

			$this->wrapper->transform($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withTransformer_throwsConstructorMetaDataException() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->keyname);
		$this->constructorMetaDataHelper->expectsHasTransformer_Success(true);
		$this->constructorMetaDataHelper->expectsGetTransformer_Success($this->transformerMock);
		$this->transformerWrapperAdapterHelper->expectsFromTransformerToTransformerWrapper_Success($this->transformerWrapperMock, $this->transformerMock);
		$this->transformerWrapperHelper->expectsTransform_Success($this->transformedValue, $this->data[$this->keyname]);

		$transformedValue = $this->wrapper->transform($this->data);

		$this->assertEquals($this->transformedValue, $transformedValue);

	}

	public function testTransform_withTransformer_throwsTransformerException_throwsConstructorMetaDataException() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->keyname);
		$this->constructorMetaDataHelper->expectsHasTransformer_Success(true);
		$this->constructorMetaDataHelper->expectsGetTransformer_Success($this->transformerMock);
		$this->transformerWrapperAdapterHelper->expectsFromTransformerToTransformerWrapper_Success($this->transformerWrapperMock, $this->transformerMock);
		$this->transformerWrapperHelper->expectsTransform_throwsTransformerException($this->data[$this->keyname]);

		$asserted = false;
		try {

			$this->wrapper->transform($this->data);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withKeynameNotInData_withNormalizedData_withClassMetaData_Success() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->normalizedKeyname);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(true);
		$this->argumentMetaDataWrapperAdapterHelper->expectsFromDataToArgumentMetaDataWrapper_Success($this->argumentMetaDataWrapperMock, [
			'argument_meta_data' => $this->argumentMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'class' => $this->className,
			'callback_on_fail' => null
		]);

		$this->argumentMetaDataWrapperHelper->expectsTransform_Success($this->transformedValue, $this->subData);

		$transformedValue = $this->wrapper->transform($this->dataWithNormalizedData);

		$this->assertEquals($this->transformedValue, $transformedValue);

	}

	public function testTransform_withKeynameNotInData_withNormalizedData_withoutClassMetaData_isNotRecursive_throwsConstructorMetaDataException() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success($this->normalizedKeyname);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$asserted = false;
		try {

			$this->wrapper->transform($this->dataWithNormalizedData);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withKeynameNotInData_withKeynameNotInData_withoutNormalizedData_throwsConstructorMetaDataException() {

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->constructorMetaDataHelper->expectsGetKeyname_Success('just_an_invalid_keyname');

		$transformedValue = $this->wrapper->transform($this->data);

		$this->assertNull($transformedValue);

	}

}
