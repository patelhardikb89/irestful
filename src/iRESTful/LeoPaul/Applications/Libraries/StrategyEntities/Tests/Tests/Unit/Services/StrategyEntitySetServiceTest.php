<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Unit\Services;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services\StrategyEntitySetService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services\EntitySetServiceHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class StrategyEntitySetServiceTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterMock;
    private $entityServiceSetMock;
    private $entityMock;
    private $containerNames;
    private $mapper;
    private $entities;
    private $firstEntities;
    private $secondEntities;
    private $serviceSet;
    private $entityAdapterHelper;
    private $serviceSetHelper;
    public function setUp() {
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityServiceSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $firstContainerName = 'first_container';
        $secondContainerName = 'second_container';

        $this->mapper = [
            $firstContainerName => $this->entityServiceSetMock,
            $secondContainerName => $this->entityServiceSetMock
        ];

        $this->containerNames = [
            $firstContainerName,
            $secondContainerName,
            $firstContainerName
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock,
            $this->entityMock
        ];

        $this->firstEntities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->secondEntities = [
            $this->entityMock
        ];

        $this->serviceSet = new StrategyEntitySetService($this->entityAdapterMock, $this->mapper);

        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->serviceSetHelper = new EntitySetServiceHelper($this, $this->entityServiceSetMock);
    }

    public function tearDown() {

    }

    public function testInsert_Success() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);
        $this->entityServiceSetMock->expects($this->exactly(2))
                                    ->method('insert')
                                    ->with($this->logicalOr(
                                        $this->equalTo($this->firstEntities),
                                        $this->equalTo($this->secondEntities)
                                    ));

        $this->serviceSet->insert($this->entities);

    }

    public function testInsert_throwsEntitySetException() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);
        $this->serviceSetHelper->expectsInsert_throwsEntitySetException($this->firstEntities);

        $asserted = false;
        try {

            $this->serviceSet->insert($this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_withOneInvalidContainerName_throwsEntitySetException() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success(array_merge(['other_container'], $this->containerNames), $this->entities);

        $asserted = false;
        try {

            $this->serviceSet->insert($this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_withBadCriteria_throwsEntityException_throwsEntitySetException() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_throwsEntityException($this->entities);

        $asserted = false;
        try {

            $this->serviceSet->insert($this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_Success() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);
        $this->entityServiceSetMock->expects($this->exactly(2))
                                    ->method('update')
                                    ->with(
                                        $this->logicalOr(
                                            $this->equalTo($this->firstEntities),
                                            $this->equalTo($this->secondEntities)
                                        ),
                                        $this->logicalOr(
                                            $this->equalTo($this->firstEntities),
                                            $this->equalTo($this->secondEntities)
                                        )
                                    );

        $this->serviceSet->update($this->entities, $this->entities);

    }

    public function testUpdate_throwsEntitySetException() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);
        $this->serviceSetHelper->expectsUpdate_throwsEntitySetException($this->firstEntities, $this->firstEntities);

        $asserted = false;
        try {

            $this->serviceSet->update($this->entities, $this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testDelete_Success() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);
        $this->entityServiceSetMock->expects($this->exactly(2))
                                    ->method('delete')
                                    ->with($this->logicalOr(
                                        $this->equalTo($this->firstEntities),
                                        $this->equalTo($this->secondEntities)
                                    ));

        $this->serviceSet->delete($this->entities);

    }

    public function testDelete_throwsEntitySetException() {

        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);
        $this->serviceSetHelper->expectsDelete_throwsEntitySetException($this->firstEntities);

        $asserted = false;
        try {

            $this->serviceSet->delete($this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
