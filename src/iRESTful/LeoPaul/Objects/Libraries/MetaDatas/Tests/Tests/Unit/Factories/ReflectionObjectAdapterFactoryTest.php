<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;

final class ReflectionObjectAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
	private $factory;
	public function setUp() {

		$delimiter = '___';

		$transformerObjects = [
			'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new ConcreteUuidAdapter(),
			'iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new ConcreteDateTimeAdapter('America/Montreal')
		];

		$containerClassMapper = [
			'complex_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntity',
			'simple_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

		$interfaceClassMapper = [
			'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

		$this->factory = new ReflectionObjectAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);
	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$objectAdapter = $this->factory->create();

		$this->assertTrue($objectAdapter instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter);

	}

}
