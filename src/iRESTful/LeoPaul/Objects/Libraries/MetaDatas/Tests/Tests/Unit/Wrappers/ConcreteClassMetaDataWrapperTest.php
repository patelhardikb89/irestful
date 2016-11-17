<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteClassMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ClassMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ConstructorMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ArgumentMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ConstructorMetaDataWrapperAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers\ConstructorMetaDataWrapperHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ConcreteClassMetaDataWrapperTest extends \PHPUnit_Framework_TestCase {
	private $objectAdapterMock;
	private $constructorMetaDataWrapperAdapterMock;
	private $constructorMetaDataWrapperMock;
	private $classMetaDataMock;
	private $constructorMetaDataMock;
	private $argumentMetaDataWrapperMock;
	private $argumentMetaDataMock;
	private $uuidMock;
	private $arguments;
	private $className;
	private $callbackOnFail;
	private $constructorMetaDataWrapperAdapterParams;
	private $transformedObjects;
	private $createdOn;
	private $uuid;
	private $title;
	private $slug;
	private $inputData;
	private $adapter;
	private $adapterWithCallbackOnFail;
	private $classMetaDataHelper;
	private $argumentMetaDataHelper;
	private $constructorMetaDataWrapperAdapterHelper;
	private $constructorMetaDataWrapperHelper;
	private $constructorMetaDataHelper;
	public function setUp() {

		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');
		$this->constructorMetaDataWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\Adapters\ConstructorMetaDataWrapperAdapter');
		$this->constructorMetaDataWrapperMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\ConstructorMetaDataWrapper');
		$this->constructorMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData');
		$this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');
		$this->argumentMetaDataWrapperMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper');
		$this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

		$this->arguments = [
			$this->constructorMetaDataMock,
			$this->constructorMetaDataMock,
			$this->constructorMetaDataMock,
			$this->constructorMetaDataMock
		];

		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity';

		$this->constructorMetaDataWrapperAdapterParams = [
			'object_adapter' => $this->objectAdapterMock,
			'constructor_meta_data' => $this->constructorMetaDataMock,
			'class' => $this->className,
			'callback_on_fail' => null
		];

		$this->createdOn = new \DateTime();
		$this->createdOn->setTimestamp(time());

		$this->title = 'This is a title';
		$this->slug = 'this-is-a-slug';

		$this->transformedObjects = [
			$this->uuidMock,
			$this->createdOn,
			$this->title,
			$this->slug
		];

		$this->uuid = '57d2ec95-4d61-4a99-bb12-c5636578d8c1';

		$this->inputData = [
			'uuid' => $this->uuid,
			'created_on' => time(),
			'title' => $this->title,
			'slug' => $this->slug
		];

		$this->adapter = new ConcreteClassMetaDataWrapper($this->objectAdapterMock, $this->constructorMetaDataWrapperAdapterMock, $this->classMetaDataMock, $this->className);

		$this->classMetaDataHelper = new ClassMetaDataHelper($this, $this->classMetaDataMock);
		$this->argumentMetaDataHelper = new ArgumentMetaDataHelper($this, $this->argumentMetaDataMock);
		$this->constructorMetaDataWrapperAdapterHelper = new ConstructorMetaDataWrapperAdapterHelper($this, $this->constructorMetaDataWrapperAdapterMock);
		$this->constructorMetaDataWrapperHelper = new ConstructorMetaDataWrapperHelper($this, $this->constructorMetaDataWrapperMock);
		$this->constructorMetaDataHelper = new ConstructorMetaDataHelper($this, $this->constructorMetaDataMock);

	}

	public function tearDown() {

	}

	public function testTransform_Success() {

		$this->classMetaDataHelper->expectsGetArguments_Success($this->arguments);

		$this->constructorMetaDataWrapperAdapterHelper->expectsFromDataToConstructorMetaDataWrapper_multiple_Success([
			$this->constructorMetaDataWrapperMock,
			$this->constructorMetaDataWrapperMock,
			$this->constructorMetaDataWrapperMock,
			$this->constructorMetaDataWrapperMock
		], [
			$this->constructorMetaDataWrapperAdapterParams,
			$this->constructorMetaDataWrapperAdapterParams,
			$this->constructorMetaDataWrapperAdapterParams,
			$this->constructorMetaDataWrapperAdapterParams
		]);

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_multiple_Success([
			$this->argumentMetaDataMock,
			$this->argumentMetaDataMock,
			$this->argumentMetaDataMock,
			$this->argumentMetaDataMock
		]);

        $this->argumentMetaDataMock->expects($this->exactly(4))
                                ->method('getPosition')
                                ->will($this->onConsecutiveCalls(0, 1, 2, 3));

		$this->constructorMetaDataWrapperHelper->expectsTransform_multiple_Success($this->transformedObjects, [
			$this->inputData,
			$this->inputData,
			$this->inputData,
			$this->inputData
		]);

		$simpleEntity = $this->adapter->transform($this->inputData);

		$this->assertTrue($simpleEntity instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity);
		$this->assertEquals($this->uuidMock, $simpleEntity->getUuid());
		$this->assertEquals($this->createdOn, $simpleEntity->createdOn());
		$this->assertEquals($this->title, $simpleEntity->getTitle());
		$this->assertEquals($this->slug, $simpleEntity->getSlug());
	}

	public function testTransform_throwsConstructorMetaDataException_whileTransforming_throwsClassMetaDataException() {

		$this->classMetaDataHelper->expectsGetArguments_Success($this->arguments);

		$this->constructorMetaDataWrapperAdapterHelper->expectsFromDataToConstructorMetaDataWrapper_Success($this->constructorMetaDataWrapperMock, $this->constructorMetaDataWrapperAdapterParams);
		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_Success($this->argumentMetaDataMock);
		$this->argumentMetaDataHelper->expectsGetPosition_Success(0);
		$this->constructorMetaDataWrapperHelper->expectsTransform_throwsConstructorMetaDataException($this->inputData);

		$asserted = false;
		try {

			$this->adapter->transform($this->inputData);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testTransform_throwsConstructorMetaDataException_throwsClassMetaDataException() {

		$this->classMetaDataHelper->expectsGetArguments_Success($this->arguments);
		$this->constructorMetaDataWrapperAdapterHelper->expectsFromDataToConstructorMetaDataWrapper_throwsConstructorMetaDataException($this->constructorMetaDataWrapperAdapterParams);

		$asserted = false;
		try {

			$this->adapter->transform($this->inputData);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testTransform_withNonArrayInput_withoutCallbackOnFail_Success() {

		$asserted = false;
		try {

			$this->adapter->transform($this->uuid);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testTransform_withNonArrayInput_hasCallbackOnFail_Success() {

		$callbackWasCalled = false;
		$uuid = $this->uuid;
		$obj = $this;
		$rightClassName = $this->className;
		$rightInputData = $this->inputData;
		$callback = function(array $data) use($uuid, $rightClassName, &$obj, &$rightInputData, &$callbackWasCalled) {

            $className = $data['class'];
            $input = $data['input'];

			$obj->assertEquals($uuid, $input);
			$obj->assertEquals($rightClassName, $className);

			$callbackWasCalled = true;
			return $rightInputData;
		};

		$constructorMetaDataWrapperAdapterParamsWithCallbackOnFail = [
			'object_adapter' => $this->objectAdapterMock,
			'constructor_meta_data' => $this->constructorMetaDataMock,
			'class' => $this->className,
			'callback_on_fail' => $callback
		];

		$adapter = new ConcreteClassMetaDataWrapper($this->objectAdapterMock, $this->constructorMetaDataWrapperAdapterMock, $this->classMetaDataMock, $this->className, $callback);

		$this->classMetaDataHelper->expectsGetArguments_Success($this->arguments);

		$this->constructorMetaDataWrapperAdapterHelper->expectsFromDataToConstructorMetaDataWrapper_multiple_Success([
			$this->constructorMetaDataWrapperMock,
			$this->constructorMetaDataWrapperMock,
			$this->constructorMetaDataWrapperMock,
			$this->constructorMetaDataWrapperMock
		], [
			$constructorMetaDataWrapperAdapterParamsWithCallbackOnFail,
			$constructorMetaDataWrapperAdapterParamsWithCallbackOnFail,
			$constructorMetaDataWrapperAdapterParamsWithCallbackOnFail,
			$constructorMetaDataWrapperAdapterParamsWithCallbackOnFail
		]);

		$this->constructorMetaDataHelper->expectsGetArgumentMetaData_multiple_Success([
			$this->argumentMetaDataMock,
			$this->argumentMetaDataMock,
			$this->argumentMetaDataMock,
			$this->argumentMetaDataMock
		]);

        $this->argumentMetaDataMock->expects($this->exactly(4))
                                ->method('getPosition')
                                ->will($this->onConsecutiveCalls(0, 1, 2, 3));

        $this->argumentMetaDataMock->expects($this->exactly(4))
                                    ->method('hasArrayMetaData')
                                    ->will($this->onConsecutiveCalls(false, false, false, false));

		$this->constructorMetaDataWrapperHelper->expectsTransform_multiple_Success($this->transformedObjects, [
			$this->inputData,
			$this->inputData,
			$this->inputData,
			$this->inputData
		]);

		$simpleEntity = $adapter->transform($this->uuid);

		$this->assertTrue($callbackWasCalled);

		$this->assertTrue($simpleEntity instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity);
		$this->assertEquals($this->uuidMock, $simpleEntity->getUuid());
		$this->assertEquals($this->createdOn, $simpleEntity->createdOn());
		$this->assertEquals($this->title, $simpleEntity->getTitle());
		$this->assertEquals($this->slug, $simpleEntity->getSlug());
	}

}
