<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Functional\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassSchemaAdapterFactory;

final class ReflectionClassSchemaAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    private $data;
    public function setUp() {
        $containerClassMapper = [
			'complex_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntity',
			'simple_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

		$interfaceClassMapper = [
			'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

        $engine = 'InnoDB';

        $this->data = [
            'name' => 'my_schema',
            'container_names' => [
                'complex_entity',
                'simple_entity'
            ]
        ];

        $this->factory = new ReflectionClassSchemaAdapterFactory($containerClassMapper, $interfaceClassMapper, $engine, '___');
    }

    public function tearDown() {

    }

    public function testCreate_thenConvert_Success() {

        $adapter = $this->factory->create();
        $schema = $adapter->fromDataToSchema($this->data);

        $this->assertTrue($schema instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema);

    }

}
