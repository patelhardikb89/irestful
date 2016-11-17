<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteArgumentMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ObjectAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ArrayMetaDataWrapperAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers\ArrayMetaDataWrapperHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ArgumentMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ClassMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ConcreteArgumentMetaDataWrapperTest extends \PHPUnit_Framework_TestCase {
	private $objectAdapterMock;
	private $arrayMetaDataWrapperAdapterMock;
	private $arrayMetaDataWrapperMock;
	private $arrayMetaDataMock;
	private $argumentMetaDataMock;
	private $classMetaDataMock;
	private $callbackOnFail;
	private $className;
	private $type;
	private $data;
	private $input;
	private $object;
	private $wrapper;
	private $wrapperWithCallbackOnFail;
	private $objectAdapterHelper;
	private $arrayMetaDataWrapperAdapterHelper;
	private $arrayMetaDataWrapperHelper;
	private $argumentMetaDataHelper;
	private $classMetaDataHelper;
	public function setUp() {
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');
		$this->arrayMetaDataWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\Adapters\ArrayMetaDataWrapperAdapter');
		$this->arrayMetaDataWrapperMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\ArrayMetaDataWrapper');
		$this->arrayMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData');
		$this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
		$this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');

		$this->callbackOnFail = function() {

		};

		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity';
		$this->type = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface';

		$this->data = [
			'some' => 'data'
		];

		$this->input = 'a5354ca1-7682-449d-a0dc-883cf3df3498';

		$this->object = 'lets say this is some returned object.';

		$this->wrapper = new ConcreteArgumentMetaDataWrapper($this->objectAdapterMock, $this->arrayMetaDataWrapperAdapterMock, $this->argumentMetaDataMock, $this->className);
		$this->wrapperWithCallbackOnFail = new ConcreteArgumentMetaDataWrapper($this->objectAdapterMock, $this->arrayMetaDataWrapperAdapterMock, $this->argumentMetaDataMock, $this->className, $this->callbackOnFail);

		$this->objectAdapterHelper = new ObjectAdapterHelper($this, $this->objectAdapterMock);
		$this->arrayMetaDataWrapperAdapterHelper = new ArrayMetaDataWrapperAdapterHelper($this, $this->arrayMetaDataWrapperAdapterMock);
		$this->arrayMetaDataWrapperHelper = new ArrayMetaDataWrapperHelper($this, $this->arrayMetaDataWrapperMock);
		$this->argumentMetaDataHelper = new ArgumentMetaDataHelper($this, $this->argumentMetaDataMock);
		$this->classMetaDataHelper = new ClassMetaDataHelper($this, $this->classMetaDataMock);
	}

	public function tearDown() {

	}

	public function testTransform_withArrayInput_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);
		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(false);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(false);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->className,
			'data' => $this->data,
			'callback_on_fail' => null
		]);

		$object = $this->wrapper->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_withArrayInput_throwsObjectException_throwsArgumentMetaDataException() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);
		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(false);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(false);

		$this->objectAdapterHelper->expectsFromDataToObject_throwsObjectException([
			'class' => $this->className,
			'data' => $this->data,
			'callback_on_fail' => null
		]);

		$asserted = false;
		try {

			$this->wrapper->transform($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withCallbackOnFail_withArrayInput_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);
		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(false);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(false);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->className,
			'data' => $this->data,
			'callback_on_fail' => $this->callbackOnFail
		]);

		$object = $this->wrapperWithCallbackOnFail->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_withArrayInput_withClassMetaData_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);
		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(false);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(true);
		$this->argumentMetaDataHelper->expectsGetClassMetaData_Success($this->classMetaDataMock);
		$this->classMetaDataHelper->expectsGetType_Success($this->type);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->type,
			'data' => $this->data,
			'callback_on_fail' => null
		]);

		$object = $this->wrapper->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_withCallbackOnFail_withArrayInput_withClassMetaData_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);
		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(false);
		$this->argumentMetaDataHelper->expectsHasClassMetaData_Success(true);
		$this->argumentMetaDataHelper->expectsGetClassMetaData_Success($this->classMetaDataMock);
		$this->classMetaDataHelper->expectsGetType_Success($this->type);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->type,
			'data' => $this->data,
			'callback_on_fail' => $this->callbackOnFail
		]);

		$object = $this->wrapperWithCallbackOnFail->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

    public function testTransform_withArrayInput_withArrayMetaData_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(true);
		$this->argumentMetaDataHelper->expectsGetArrayMetaData_Success($this->arrayMetaDataMock);
		$this->arrayMetaDataWrapperAdapterHelper->expectsFromDataToArrayMetaDataWrappera_Success($this->arrayMetaDataWrapperMock, [
			'array_meta_data' => $this->arrayMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'callback_on_fail' => null
		]);
		$this->arrayMetaDataWrapperHelper->expectsTransform_Success($this->object, $this->data);

		$object = $this->wrapper->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

    public function testTransform_withArrayInput_withArrayMetaData_withNullData_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(true);

		$object = $this->wrapper->transform(null);

		$this->assertEquals([], $object);

	}

    public function testTransform_withArrayInput_withArrayMetaData_withEmptyData_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(true);

		$object = $this->wrapper->transform([]);

		$this->assertEquals([], $object);

	}

	public function testTransform_withArrayInput_withArrayMetaData_throwsArrayMetaDataException_onTransform_throwsArrayMetaDataException() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(true);
		$this->argumentMetaDataHelper->expectsGetArrayMetaData_Success($this->arrayMetaDataMock);
		$this->arrayMetaDataWrapperAdapterHelper->expectsFromDataToArrayMetaDataWrappera_Success($this->arrayMetaDataWrapperMock, [
			'array_meta_data' => $this->arrayMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'callback_on_fail' => null
		]);
		$this->arrayMetaDataWrapperHelper->expectsTransform_throwsArrayMetaDataException($this->data);

		$asserted = false;
		try {

			$this->wrapper->transform($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withArrayInput_withArrayMetaData_throwsArrayMetaDataException_throwsArrayMetaDataException() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(true);
		$this->argumentMetaDataHelper->expectsGetArrayMetaData_Success($this->arrayMetaDataMock);
		$this->arrayMetaDataWrapperAdapterHelper->expectsFromDataToArrayMetaDataWrapper_throwsArrayMetaDataException([
			'array_meta_data' => $this->arrayMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'callback_on_fail' => null
		]);

		$asserted = false;
		try {

			$this->wrapper->transform($this->data);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withCallbackOnFail_withArrayInput_withArrayMetaData_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(true);
		$this->argumentMetaDataHelper->expectsGetArrayMetaData_Success($this->arrayMetaDataMock);
		$this->arrayMetaDataWrapperAdapterHelper->expectsFromDataToArrayMetaDataWrappera_Success($this->arrayMetaDataWrapperMock, [
			'array_meta_data' => $this->arrayMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'callback_on_fail' => $this->callbackOnFail
		]);
		$this->arrayMetaDataWrapperHelper->expectsTransform_Success($this->object, $this->data);

		$object = $this->wrapperWithCallbackOnFail->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_isRecursive_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(true);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->className,
			'data' => $this->data,
			'callback_on_fail' => null
		]);

		$object = $this->wrapper->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_withCallbackOnFail_isRecursive_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(true);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->className,
			'data' => $this->data,
			'callback_on_fail' => $this->callbackOnFail
		]);

		$object = $this->wrapperWithCallbackOnFail->transform($this->data);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_withStringInput_isRecursive_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(true);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->className,
			'data' => $this->input,
			'callback_on_fail' => null
		]);

		$object = $this->wrapper->transform($this->input);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_withCallbackOnFail_withStringInput_isRecursive_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(true);

		$this->objectAdapterHelper->expectsFromDataToObject_Success($this->object, [
			'class' => $this->className,
			'data' => $this->input,
			'callback_on_fail' => $this->callbackOnFail
		]);

		$object = $this->wrapperWithCallbackOnFail->transform($this->input);

		$this->assertEquals($this->object, $object);

	}

	public function testTransform_isOptional_withNullInput_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(true);

		$value = $this->wrapper->transform(null);

		$this->assertNull($value);

	}

	public function testTransform_withStringInput_Success() {

		$this->argumentMetaDataHelper->expectsIsOptional_Success(false);
		$this->argumentMetaDataHelper->expectsIsRecursive_Success(false);
		$this->argumentMetaDataHelper->expectsHasArrayMetaData_Success(false);

		$output = $this->wrapper->transform($this->input);

		$this->assertEquals($this->input, $output);

	}

}
