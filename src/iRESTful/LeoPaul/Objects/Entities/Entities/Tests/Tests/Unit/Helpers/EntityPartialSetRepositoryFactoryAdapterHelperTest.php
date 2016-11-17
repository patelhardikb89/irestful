<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetRepositoryFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRepositoryFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRepositoryFactoryAdapterMock;
    private $entityPartialSetRepositoryFactoryMock;
    private $data;
    private $phpunit;
    public function setUp() {
        $this->entityPartialSetRepositoryFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\Adapters\EntityPartialSetRepositoryFactoryAdapter');
        $this->entityPartialSetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntityPartialSetRepositoryFactoryAdapterHelper($this, $this->entityPartialSetRepositoryFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testfromDataToEntityPartialSetRepositoryFactory_Success() {

        $this->helper->expectsFromDataToEntityPartialSetRepositoryFactory_Success($this->entityPartialSetRepositoryFactoryMock, $this->data);

        $factory = $this->entityPartialSetRepositoryFactoryAdapterMock->fromDataToEntityPartialSetRepositoryFactory($this->data);

        $this->assertTrue($factory instanceof $this->entityPartialSetRepositoryFactoryMock);

    }

    public function testfromDataToEntityPartialSetRepositoryFactory_throwsEntityPartialSetException() {

        $this->helper->expectsFromDataToEntityPartialSetRepositoryFactory_throwsEntityPartialSetException($this->data);

        $asserted = false;
        try {

            $this->entityPartialSetRepositoryFactoryAdapterMock->fromDataToEntityPartialSetRepositoryFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
