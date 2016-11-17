<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityPartialSetHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class ConcreteEntityPartialSetAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetMock;
    private $entityAdapterMock;
    private $entityMock;
    private $index;
    private $amount;
    private $totalAmount;
    private $entities;
    private $entitiesData;
    private $data;
    private $dataWithEntities;
    private $fromData;
    private $fromDataWithEntities;
    private $fromDataWithEmptyEntities;
    private $fromDataWithNullEntities;
    private $adapter;
    private $entityAdapterHelper;
    private $entityPartialSetHelper;
    public function setUp() {
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->index = rand(0, 100);
        $this->amount = count($this->entities);
        $this->totalAmount = $this->index + $this->amount + rand(0, 100);

        $containerName = 'my_container';
        $this->entitiesData = [
            [
                'container' => $containerName,
                'data' => [
                    'uuid' => '4d3c0f42-60fd-4757-a0ff-cd0c1fd3efc1',
                    'title' => 'My First Title'
                ]
            ],
            [
                'container' => $containerName,
                'data' => [
                    'uuid' => '1a4d15b2-2bde-49f1-9657-c91b3f898fbe',
                    'title' => 'My Second Title'
                ]
            ]
        ];

        $this->data = [
            'index' => $this->index,
            'amount' => 0,
            'total_amount' => $this->totalAmount
        ];

        $this->dataWithEntities = [
            'index' => $this->index,
            'amount' => $this->amount,
            'total_amount' => $this->totalAmount,
            'entities' => $this->entitiesData
        ];

        $this->fromData = [
            'index' => $this->index,
            'total_amount' => $this->totalAmount
        ];

        $this->fromDataWithEntities = [
            'index' => $this->index,
            'total_amount' => $this->totalAmount,
            'entities' => $this->entities
        ];

        $this->fromDataWithEmptyEntities = [
            'index' => $this->index,
            'total_amount' => $this->totalAmount,
            'entities' => []
        ];

        $this->fromDataWithNullEntities = [
            'index' => $this->index,
            'total_amount' => $this->totalAmount,
            'entities' => null
        ];

        $this->adapter = new ConcreteEntityPartialSetAdapter($this->entityAdapterMock);

        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->entityPartialSetHelper = new EntityPartialSetHelper($this, $this->entityPartialSetMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSet_Success() {

        $entityPartialSet = $this->adapter->fromDataToEntityPartialSet($this->fromData);

        $this->assertEquals($this->index, $entityPartialSet->getIndex());
        $this->assertEquals(0, $entityPartialSet->getAmount());
        $this->assertEquals($this->totalAmount, $entityPartialSet->getTotalAmount());
        $this->assertFalse($entityPartialSet->hasEntities());
        $this->assertNull($entityPartialSet->getEntities());


    }

    public function testFromDataToEntityPartialSet_withEmptyEntities_Success() {

        $entityPartialSet = $this->adapter->fromDataToEntityPartialSet($this->fromDataWithEmptyEntities);

        $this->assertEquals($this->index, $entityPartialSet->getIndex());
        $this->assertEquals(0, $entityPartialSet->getAmount());
        $this->assertEquals($this->totalAmount, $entityPartialSet->getTotalAmount());
        $this->assertFalse($entityPartialSet->hasEntities());
        $this->assertNull($entityPartialSet->getEntities());


    }

    public function testFromDataToEntityPartialSet_withEntities_Success() {

        $entityPartialSet = $this->adapter->fromDataToEntityPartialSet($this->fromDataWithEntities);

        $this->assertEquals($this->index, $entityPartialSet->getIndex());
        $this->assertEquals(count($this->entities), $entityPartialSet->getAmount());
        $this->assertEquals($this->totalAmount, $entityPartialSet->getTotalAmount());
        $this->assertTrue($entityPartialSet->hasEntities());
        $this->assertEquals($this->entities, $entityPartialSet->getEntities());


    }

    public function testFromDataToEntityPartialSet_withEntitiesData_Success() {

        $this->entityAdapterHelper->expectsFromDataToEntities_Success($this->entities, $this->entitiesData);

        $entityPartialSet = $this->adapter->fromDataToEntityPartialSet($this->dataWithEntities);

        $this->assertEquals($this->index, $entityPartialSet->getIndex());
        $this->assertEquals(count($this->entities), $entityPartialSet->getAmount());
        $this->assertEquals($this->totalAmount, $entityPartialSet->getTotalAmount());
        $this->assertTrue($entityPartialSet->hasEntities());
        $this->assertEquals($this->entities, $entityPartialSet->getEntities());


    }

    public function testFromDataToEntityPartialSet_withInvalidEntities_throwsEntityPartialSetException() {

        $this->dataWithEntities['entities'] = [
            new \DateTime(),
            new \DateTime()
        ];

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSet($this->dataWithEntities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

    public function testFromDataToEntityPartialSet_withoutIndex_Success() {

        unset($this->fromData['index']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSet($this->fromData);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

    public function testFromDataToEntityPartialSet_withoutTotalAmount_Success() {

        unset($this->fromData['total_amount']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSet($this->fromData);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

    public function testFromDataToEntityPartialSet_withNullEntities_Success() {

        $entityPartialSet = $this->adapter->fromDataToEntityPartialSet($this->fromDataWithNullEntities);

        $this->assertEquals($this->index, $entityPartialSet->getIndex());
        $this->assertEquals(0, $entityPartialSet->getAmount());
        $this->assertEquals($this->totalAmount, $entityPartialSet->getTotalAmount());
        $this->assertFalse($entityPartialSet->hasEntities());
        $this->assertNull($entityPartialSet->getEntities());


    }

    public function testFromEntityPartialSetToData_Success() {

        $this->entityPartialSetHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetHelper->expectsGetAmount_Success(0);
        $this->entityPartialSetHelper->expectsGetTotalAmount_Success($this->totalAmount);
        $this->entityPartialSetHelper->expectsHasEntities_Success(false);

        $output = $this->adapter->fromEntityPartialSetToData($this->entityPartialSetMock);

        $this->assertEquals($this->data, $output);

    }

    public function testFromEntityPartialSetToData_withEntities_Success() {

        $this->entityPartialSetHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetHelper->expectsGetTotalAmount_Success($this->totalAmount);
        $this->entityPartialSetHelper->expectsHasEntities_Success(true);
        $this->entityPartialSetHelper->expectsGetEntities_Success($this->entities);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->entitiesData, $this->entities, true);

        $output = $this->adapter->fromEntityPartialSetToData($this->entityPartialSetMock);

        $this->assertEquals($this->dataWithEntities, $output);

    }

    public function testFromEntityPartialSetToData_withEntities_throwsEntityException_throwsEntityPartialSetException() {

        $this->entityPartialSetHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetHelper->expectsGetTotalAmount_Success($this->totalAmount);
        $this->entityPartialSetHelper->expectsHasEntities_Success(true);
        $this->entityPartialSetHelper->expectsGetEntities_Success($this->entities);
        $this->entityAdapterHelper->expectsFromEntitiesToData_throwsEntityException($this->entities, true);

        $asserted = false;
        try {

            $this->adapter->fromEntityPartialSetToData($this->entityPartialSetMock);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
