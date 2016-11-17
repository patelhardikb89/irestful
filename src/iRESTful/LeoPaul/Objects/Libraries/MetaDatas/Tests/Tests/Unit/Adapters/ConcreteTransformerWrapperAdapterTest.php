<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTransformerWrapperAdapter;

final class ConcreteTransformerWrapperAdapterTest extends \PHPUnit_Framework_TestCase {
	private $transformerMock;
	private $transformerObjects;
	private $adapter;
	public function setUp() {
		$this->transformerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer');

		$this->transformerObjects = [
			'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter')
		];

		$this->adapter = new ConcreteTransformerWrapperAdapter($this->transformerObjects);
	}

	public function tearDown() {

	}

	public function testFromTransformerToTransformerWrapper_Success() {

		$transformerWrapper = $this->adapter->fromTransformerToTransformerWrapper($this->transformerMock);

		$this->assertTrue($transformerWrapper instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\TransformerWrapper);

	}

}
