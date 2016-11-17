<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityPartialSetRetrieverCriteriaAdapterFactory;

final class ConcreteEntityPartialSetRetrieverCriteriaAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    public function setUp() {
        $this->factory = new ConcreteEntityPartialSetRetrieverCriteriaAdapterFactory();
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $adapter = $this->factory->create();

        $this->assertTrue($adapter instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter);

    }

}
