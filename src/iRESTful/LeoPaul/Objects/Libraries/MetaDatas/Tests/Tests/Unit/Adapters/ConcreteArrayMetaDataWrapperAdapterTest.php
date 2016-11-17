<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArrayMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ConcreteArrayMetaDataWrapperAdapterTest extends \PHPUnit_Framework_TestCase {
    private $transformerWrapperAdapterMock;
	private $arrayMetaDataMock;
	private $objectAdapterMock;
	private $data;
	private $dataWithCallbackOnFail;
	private $adapter;
	public function setUp() {
        $this->transformerWrapperAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter');
		$this->arrayMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData');
		$this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');

		$this->data = [
			'array_meta_data' => $this->arrayMetaDataMock,
			'object_adapter' => $this->objectAdapterMock
		];

		$this->dataWithCallbackOnFail = [
			'array_meta_data' => $this->arrayMetaDataMock,
			'object_adapter' => $this->objectAdapterMock,
			'callback_on_fail' => function() {

			}
		];

		$this->adapter = new ConcreteArrayMetaDataWrapperAdapter($this->transformerWrapperAdapterMock);
	}

	public function tearDown() {

	}

	public function testFromDataToArrayMetaDataWrapper_Success() {

		$arrayMetaDataWrapper = $this->adapter->fromDataToArrayMetaDataWrapper($this->data);

		$this->assertTrue($arrayMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\ArrayMetaDataWrapper);

	}

	public function testFromDataToArrayMetaDataWrapper_withoutArrayMetaData_throwsArrayMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['array_meta_data']);
			$this->adapter->fromDataToArrayMetaDataWrapper($this->data);

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToArrayMetaDataWrapper_withoutObjectAdapter_throwsArrayMetaDataException() {

		$asserted = false;
		try {

			unset($this->data['object_adapter']);
			$this->adapter->fromDataToArrayMetaDataWrapper($this->data);

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToArrayMetaDataWrapper_withCallbackOnFail_Success() {

		$arrayMetaDataWrapper = $this->adapter->fromDataToArrayMetaDataWrapper($this->dataWithCallbackOnFail);

		$this->assertTrue($arrayMetaDataWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\ArrayMetaDataWrapper);

	}

}
