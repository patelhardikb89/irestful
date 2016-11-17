<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArrayMetaDataAdapter;

final class ConcreteArrayMetaDataAdapterTest extends \PHPUnit_Framework_TestCase {
    private $transformerAdapterMock;
	private $data;
	private $adapter;
	public function setUp() {

        $this->transformerAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters\TransformerAdapter');

		$this->data = [
			'elements_type' => get_class($this)
		];

		$this->adapter = new ConcreteArrayMetaDataAdapter($this->transformerAdapterMock);

	}

	public function tearDown() {

	}

	public function testFromDataToArrayMetaData_Success() {

		$arrayMetaData = $this->adapter->fromDataToArrayMetaData([]);

		$this->assertFalse($arrayMetaData->hasElementsType());
		$this->assertNull($arrayMetaData->getElementsType());
	}

	public function testFromDataToArrayMetaData_withElementsType_Success() {

		$arrayMetaData = $this->adapter->fromDataToArrayMetaData($this->data);

		$this->assertTrue($arrayMetaData->hasElementsType());
		$this->assertEquals($this->data['elements_type'], $arrayMetaData->getElementsType());
	}

}
