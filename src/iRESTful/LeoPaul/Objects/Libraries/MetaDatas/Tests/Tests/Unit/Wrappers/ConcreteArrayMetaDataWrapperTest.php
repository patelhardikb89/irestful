<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ObjectAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ArrayMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteArrayMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ConcreteArrayMetaDataWrapperTest extends \PHPUnit_Framework_TestCase {
    private $transformerWrapperAdapterMock;
	private $objectAdapterMock;
	private $arrayMetaDataMock;
	private $callBackOnFail;
	private $elementsType;
	private $input;
	private $output;
	private $wrapper;
	private $wrapperWithCallbackOnFail;
	private $objectAdapterHelper;
	private $arrayMetaDataHelper;
	public function setUp() {
        $this->transformerWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter');
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');
		$this->arrayMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData');
		$this->callBackOnFail = function() {

		};

		$this->elementsType = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity';

		$this->input = [
			[
				'uuid' => 'b107e161-983f-457e-a5ef-b4c37d851f0d',
				'created_on' => time(),
				'title' =>'Some Title',
				'slug' => 'some-title'
			],
			[
				'uuid' => 'e221c82e-ee44-4797-bdee-715f5881cfe4',
				'created_on' => time(),
				'title' =>'Another Title',
				'slug' => 'another-title'
			]
		];

		$simpleEntityMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface');

		$this->output = [
			$simpleEntityMock,
			$simpleEntityMock
		];

		$this->wrapper = new ConcreteArrayMetaDataWrapper($this->transformerWrapperAdapterMock, $this->objectAdapterMock, $this->arrayMetaDataMock);
		$this->wrapperWithCallbackOnFail = new ConcreteArrayMetaDataWrapper($this->transformerWrapperAdapterMock, $this->objectAdapterMock, $this->arrayMetaDataMock, $this->callBackOnFail);

		$this->objectAdapterHelper = new ObjectAdapterHelper($this, $this->objectAdapterMock);
		$this->arrayMetaDataHelper = new ArrayMetaDataHelper($this, $this->arrayMetaDataMock);
	}

	public function tearDown() {

	}

	public function testTransform_Success() {

		$this->arrayMetaDataHelper->expectsHasElementsType_Success(true);
		$this->arrayMetaDataHelper->expectsGetElementsType_Success($this->elementsType);
		$this->objectAdapterHelper->expectsFromDataToObjects_Success($this->output, [
			[
				'class' => $this->elementsType,
				'callback_on_fail' => null,
				'data' => $this->input[0]
			],
			[
				'class' => $this->elementsType,
				'callback_on_fail' => null,
				'data' => $this->input[1]
			]
		]);

		$objects = $this->wrapper->transform($this->input);

		$this->assertEquals($this->output, $objects);

	}

	public function testTransform_throwsObjectException_throwsArrayMetaDataException() {

		$this->arrayMetaDataHelper->expectsHasElementsType_Success(true);
		$this->arrayMetaDataHelper->expectsGetElementsType_Success($this->elementsType);
		$this->objectAdapterHelper->expectsFromDataToObjects_throwsObjectException([
			[
				'class' => $this->elementsType,
				'callback_on_fail' => null,
				'data' => $this->input[0]
			],
			[
				'class' => $this->elementsType,
				'callback_on_fail' => null,
				'data' => $this->input[1]
			]
		]);

		$asserted = false;
		try {

			$this->wrapper->transform($this->input);

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withoutElementsType_throwsArrayMetaDataException() {

		$this->arrayMetaDataHelper->expectsHasElementsType_Success(false);

		$asserted = false;
		try {

			$this->wrapper->transform($this->input);

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withCallbackOnFail_Success() {

		$this->arrayMetaDataHelper->expectsHasElementsType_Success(true);
		$this->arrayMetaDataHelper->expectsGetElementsType_Success($this->elementsType);
		$this->objectAdapterHelper->expectsFromDataToObjects_Success($this->output, [
			[
				'class' => $this->elementsType,
				'callback_on_fail' => $this->callBackOnFail,
				'data' => $this->input[0]
			],
			[
				'class' => $this->elementsType,
				'callback_on_fail' => $this->callBackOnFail,
				'data' => $this->input[1]
			]
		]);

		$objects = $this->wrapperWithCallbackOnFail->transform($this->input);

		$this->assertEquals($this->output, $objects);

	}

}
