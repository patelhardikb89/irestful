<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\KeynameAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\OrderingAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class ConcreteEntitySetRetrieverCriteriaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $uuidAdapterMock;
    private $uuidMock;
    private $keynameAdapterMock;
    private $keynameMock;
    private $orderingAdapterMock;
    private $orderingMock;
    private $uuids;
    private $containerName;
    private $dataWithUuids;
    private $dataWithKeyname;
    private $dataWithUuidsWithOrdering;
    private $dataWithKeynameWithOrdering;
    private $uuidsData;
    private $keynameData;
    private $orderingData;
    private $adapter;
    private $uuidAdapterHelper;
    private $keynameAdapterHelper;
    private $orderingAdapterHelper;
    public function setUp() {
        $this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->keynameAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters\KeynameAdapter');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');
        $this->orderingAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->uuids = [
            $this->uuidMock,
            $this->uuidMock
        ];

        $this->containerName = 'my_container';

        $this->uuidsData = [
            hex2bin(str_replace('-', '', '1b8d152c-f336-4326-a0a1-97eeab56ff41')),
            hex2bin(str_replace('-', '', 'b827487e-66e0-4740-9bc6-18afbd83fb47'))
        ];

        $this->keynameData = [
            'name' => 'slug',
            'value' => 'this-is-a-slug'
        ];

        $this->orderingData = [
            'names' => ['slug', 'created_on'],
            'is_ascending' => false
        ];

        $this->dataWithUuids = [
            'container' => $this->containerName,
            'uuids' => $this->uuidsData
        ];

        $this->dataWithUuidsWithOrdering = [
            'container' => $this->containerName,
            'uuids' => $this->uuidsData,
            'ordering' => $this->orderingData
        ];

        $this->dataWithKeyname = [
            'container' => $this->containerName,
            'keyname' => $this->keynameData
        ];

        $this->dataWithKeynameWithOrdering = [
            'container' => $this->containerName,
            'keyname' => $this->keynameData,
            'ordering' => $this->orderingData
        ];

        $this->adapter = new ConcreteEntitySetRetrieverCriteriaAdapter($this->uuidAdapterMock, $this->keynameAdapterMock, $this->orderingAdapterMock);

        $this->uuidAdapterHelper = new UuidAdapterHelper($this, $this->uuidAdapterMock);
        $this->keynameAdapterHelper = new KeynameAdapterHelper($this, $this->keynameAdapterMock);
        $this->orderingAdapterHelper = new OrderingAdapterHelper($this, $this->orderingAdapterMock);
    }

    public function tearDown() {

    }

    public function testfromDataToEntitySetRetrieverCriteria_withUuids_Success() {

        $this->uuidAdapterHelper->expectsFromStringsToUuids_Success($this->uuids, $this->uuidsData);

        $criteria = $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithUuids);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertTrue($criteria->hasUuids());
        $this->assertEquals($this->uuids, $criteria->getUuids());
        $this->assertFalse($criteria->hasKeyname());
        $this->assertNull($criteria->getKeyname());
        $this->assertFalse($criteria->hasOrdering());
        $this->assertNull($criteria->getOrdering());

    }

    public function testfromDataToEntitySetRetrieverCriteria_withUuids_withOrdering_Success() {

        $this->uuidAdapterHelper->expectsFromStringsToUuids_Success($this->uuids, $this->uuidsData);
        $this->orderingAdapterHelper ->expectsFromDataToOrdering_Success($this->orderingMock, $this->orderingData);

        $criteria = $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithUuidsWithOrdering);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertTrue($criteria->hasUuids());
        $this->assertEquals($this->uuids, $criteria->getUuids());
        $this->assertFalse($criteria->hasKeyname());
        $this->assertNull($criteria->getKeyname());
        $this->assertTrue($criteria->hasOrdering());
        $this->assertEquals($this->orderingMock, $criteria->getOrdering());

    }

    public function testfromDataToEntitySetRetrieverCriteria_withUuids_withOrdering_throwsOrderingException_throwsEntitySetException() {

        $this->uuidAdapterHelper->expectsFromStringsToUuids_Success($this->uuids, $this->uuidsData);
        $this->orderingAdapterHelper ->expectsFromDataToOrdering_throwsOrderingException($this->orderingData);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithUuidsWithOrdering);

        } catch(EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfromDataToEntitySetRetrieverCriteria_withUuids_withOrdering_throwsUuidException_throwsEntitySetException() {

        $this->uuidAdapterHelper->expectsFromStringsToUuids_throwsUuidException($this->uuidsData);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithUuidsWithOrdering);

        } catch(EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfromDataToEntitySetRetrieverCriteria_withKeyname_Success() {

        $this->keynameAdapterHelper->expectsFromDataToKeyname_Success($this->keynameMock, $this->keynameData);

        $criteria = $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithKeyname);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertFalse($criteria->hasUuids());
        $this->assertNull($criteria->getUuids());
        $this->assertTrue($criteria->hasKeyname());
        $this->assertEquals($this->keynameMock, $criteria->getKeyname());
        $this->assertFalse($criteria->hasOrdering());
        $this->assertNull($criteria->getOrdering());

    }

    public function testfromDataToEntitySetRetrieverCriteria_withKeyname_withOrdering_Success() {

        $this->keynameAdapterHelper->expectsFromDataToKeyname_Success($this->keynameMock, $this->keynameData);
        $this->orderingAdapterHelper ->expectsFromDataToOrdering_Success($this->orderingMock, $this->orderingData);

        $criteria = $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithKeynameWithOrdering);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertFalse($criteria->hasUuids());
        $this->assertNull($criteria->getUuids());
        $this->assertTrue($criteria->hasKeyname());
        $this->assertEquals($this->keynameMock, $criteria->getKeyname());
        $this->assertTrue($criteria->hasOrdering());
        $this->assertEquals($this->orderingMock, $criteria->getOrdering());

    }

    public function testfromDataToEntitySetRetrieverCriteria_withKeyname_withOrdering_throwsOrderingException_throwsEntitySetException() {

        $this->keynameAdapterHelper->expectsFromDataToKeyname_Success($this->keynameMock, $this->keynameData);
        $this->orderingAdapterHelper ->expectsFromDataToOrdering_throwsOrderingException($this->orderingData);

        $asserted = true;
        try {

            $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithKeynameWithOrdering);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfromDataToEntitySetRetrieverCriteria_withKeyname_withOrdering_throwsKeynameException_throwsEntitySetException() {

        $this->keynameAdapterHelper->expectsFromDataToKeyname_throwsKeynameException($this->keynameData);

        $asserted = true;
        try {

            $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithKeynameWithOrdering);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfromDataToEntitySetRetrieverCriteria_withKeyname_withOrdering_withoutContainer_throwsEntitySetException() {

        $asserted = true;
        try {

            unset($this->dataWithKeynameWithOrdering['container']);
            $this->adapter->fromDataToEntitySetRetrieverCriteria($this->dataWithKeynameWithOrdering);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
