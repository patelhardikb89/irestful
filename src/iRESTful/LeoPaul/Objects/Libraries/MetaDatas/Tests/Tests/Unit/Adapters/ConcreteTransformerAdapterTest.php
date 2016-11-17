<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTransformerAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;

final class ConcreteTransformerAdapterTest extends \PHPUnit_Framework_TestCase {
	private $data;
	private $adapter;
	public function setUp() {
		$this->data = [
			'type' => get_class($this),
			'method_name' => 'setUp'
		];

		$this->adapter = new ConcreteTransformerAdapter();
	}

	public function tearDown() {

	}

	public function testFromDataToTransformer_Success() {

		$transformer = $this->adapter->fromDataToTransformer($this->data);

		$this->assertEquals($this->data['type'], $transformer->getType());
		$this->assertEquals($this->data['method_name'], $transformer->getMethodName());

	}

	public function testFromDataToTransformer_withoutType_Success() {

		$asserted = false;
		try {

			unset($this->data['type']);
			$this->adapter->fromDataToTransformer($this->data);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToTransformer_withoutMethodName_Success() {

		$asserted = false;
		try {

			unset($this->data['method_name']);
			$this->adapter->fromDataToTransformer($this->data);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
