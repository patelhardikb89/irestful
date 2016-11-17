<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntitySetRetrieverCriteriaAdapterFactory;

final class ConcreteEntitySetRetrieverCriteriaAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    public function setUp() {
        $this->factory = new ConcreteEntitySetRetrieverCriteriaAdapterFactory();
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $adapter = $this->factory->create();

        $this->assertTrue($adapter instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter);

    }

}
