<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRelationRepositoryFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class EntityRelationRepositoryFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryFactoryAdapterMock;
    private $entityRelationRepositoryFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entityRelationRepositoryFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\Adapters\EntityRelationRepositoryFactoryAdapter');
        $this->entityRelationRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntityRelationRepositoryFactoryAdapterHelper($this, $this->entityRelationRepositoryFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityRelationRepositoryFactory_Success() {

        $this->helper->expectsFromDataToEntityRelationRepositoryFactory_Success($this->entityRelationRepositoryFactoryMock, $this->data);

        $factory = $this->entityRelationRepositoryFactoryAdapterMock->fromDataToEntityRelationRepositoryFactory($this->data);

        $this->assertEquals($this->entityRelationRepositoryFactoryMock, $factory);

    }

    public function testFromDataToEntityRelationRepositoryFactory_throwsEntityRelationException() {

        $this->helper->expectsFromDataToEntityRelationRepositoryFactory_throwsEntityRelationException($this->data);

        $asserted = false;
        try {

            $this->entityRelationRepositoryFactoryAdapterMock->fromDataToEntityRelationRepositoryFactory($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
