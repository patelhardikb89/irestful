<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteObjectMetaDataAdapter;

final class ConcreteObjectMetaDataAdapterTest extends \PHPUnit_Framework_TestCase {
	private $object;
	private $adapter;
	public function setUp() {
		$this->object = new \DateTime();
		$this->adapter = new ConcreteObjectMetaDataAdapter();
	}

	public function tearDown() {

	}

	public function testFromObjectToObjectMetaData_Success() {

		$objectMetaData = $this->adapter->fromObjectToObjectMetaData($this->object);

		$this->assertTrue($objectMetaData instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\ObjectMetaData);
		$this->assertEquals($this->object, $objectMetaData->getObject());

	}

}
