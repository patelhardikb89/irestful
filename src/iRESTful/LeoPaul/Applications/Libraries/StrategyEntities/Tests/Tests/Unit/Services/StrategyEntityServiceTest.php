<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Unit\Services;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services\StrategyEntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services\EntityServiceHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class StrategyEntityServiceTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterMock;
    private $entityServiceMock;
    private $entityMock;
    private $containerName;
    private $mapper;
    private $service;
    private $entityAdapterHelper;
    private $entityServiceHelper;
    public function setUp() {
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->containerName = 'my_container';

        $this->mapper = [
            $this->containerName => $this->entityServiceMock
        ];

        $this->service = new StrategyEntityService($this->entityAdapterMock, $this->mapper);

        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->entityServiceHelper = new EntityServiceHelper($this, $this->entityServiceMock);
    }

    public function tearDown() {

    }

    public function testInsert_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityServiceHelper->expectsInsert_Success($this->entityMock);

        $this->service->insert($this->entityMock);

    }

    public function testInsert_throwsEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityServiceHelper->expectsInsert_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->service->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_containerNotInMapper_throwsEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success('some_container', $this->entityMock);

        $asserted = false;
        try {

            $this->service->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_entityDoesNotHaveContainerName_throwsEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->service->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityServiceHelper->expectsUpdate_Success($this->entityMock, $this->entityMock);

        $this->service->update($this->entityMock, $this->entityMock);

    }

    public function testUpdate_throwsEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityServiceHelper->expectsUpdate_throwsEntityException($this->entityMock, $this->entityMock);

        $asserted = false;
        try {

            $this->service->update($this->entityMock, $this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testDelete_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityServiceHelper->expectsDelete_Success($this->entityMock);

        $this->service->delete($this->entityMock);

    }

    public function testDelete_throwsEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityServiceHelper->expectsDelete_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->service->delete($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
