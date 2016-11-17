<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\KeynameHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Exceptions\RequestSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\OrderingHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntitySetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntitySetRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;

final class ConcreteRequestSetAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRetrieverCriteriaAdapterMock;
    private $entitySetRetrieverCriteriaMock;
    private $uuidAdapterMock;
    private $uuidMock;
    private $orderingMock;
    private $keynameMock;
    private $orderingNames;
    private $orderByQuery;
    private $orderByQueryASC;
    private $setCriteria;
    private $containerName;
    private $uuid;
    private $uuids;
    private $uuidsData;
    private $firstKeynameName;
    private $firstKeynameValue;
    private $data;
    private $adapter;
    private $entitySetRetrieverCriteriaAdapterHelper;
    private $entitySetRetrieverCriteriaHelper;
    private $uuidAdapterHelper;
    private $orderingHelper;
    private $keynameHelper;
    public function setUp() {

        $this->entitySetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter');
        $this->entitySetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria');
        $this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->orderingNames = [
            'created_on',
            'title'
        ];

        $this->orderByQuery = ' order by created_on, title desc';
        $this->orderByQueryASC = ' order by created_on, title asc';

        $this->setCriteria = [
            'container' => 'my_container',
            'uuids' => [
                '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b',
                '40988d18-9d7d-4133-a3a3-77d16c1837b7'
            ]
        ];

        $this->containerName = 'my_container';

        $this->uuid = hex2bin(str_replace('-', '', '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b'));

        $this->uuids = [
            $this->uuid,
            hex2bin(str_replace('-', '', '40988d18-9d7d-4133-a3a3-77d16c1837b7'))
        ];

        $this->uuidsData = [
            $this->uuidMock,
            $this->uuidMock
        ];

        $this->firstKeynameName = 'slug';
        $this->firstKeynameValue = 'this-is-a-slug';

        $this->adapter = new ConcreteRequestSetAdapter($this->entitySetRetrieverCriteriaAdapterMock, $this->uuidAdapterMock);

        $this->entitySetRetrieverCriteriaAdapterHelper = new EntitySetRetrieverCriteriaAdapterHelper($this, $this->entitySetRetrieverCriteriaAdapterMock);
        $this->entitySetRetrieverCriteriaHelper = new EntitySetRetrieverCriteriaHelper($this, $this->entitySetRetrieverCriteriaMock);
        $this->uuidAdapterHelper = new UuidAdapterHelper($this, $this->uuidAdapterMock);
        $this->keynameHelper = new KeynameHelper($this, $this->keynameMock);
        $this->orderingHelper = new OrderingHelper($this, $this->orderingMock);

    }

    public function tearDown() {

    }

    public function testFromEntitySetRetrieverCriteriaToRequest_withUuids_Success() {

        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuidsData);
        $this->uuidAdapterHelper->expectsFromUuidsToBinaryStrings_Success($this->uuids, $this->uuidsData);

        $request = $this->adapter->fromEntitySetRetrieverCriteriaToRequest($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' where uuid IN(:0, :1);',
            'params' => $this->uuids
        ], $request);

    }

    public function testFromEntitySetRetrieverCriteriaToRequest_withUuids_withOrdering_Success() {

        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingHelper->expectsGetNames_Success($this->orderingNames);
        $this->orderingHelper->expectsIsAscending_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuidsData);
        $this->uuidAdapterHelper->expectsFromUuidsToBinaryStrings_Success($this->uuids, $this->uuidsData);

        $request = $this->adapter->fromEntitySetRetrieverCriteriaToRequest($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' where uuid IN(:0, :1)'.$this->orderByQuery.';',
            'params' => $this->uuids
        ], $request);

    }

    public function testFromEntitySetRetrieverCriteriaToRequest_withUuids_throwsUuidException_throwsRequestSetException() {

        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuidsData);
        $this->uuidAdapterHelper->expectsFromUuidsToBinaryStrings_throwsUuidException($this->uuidsData);

        $asserted = false;
        try {

            $this->adapter->fromEntitySetRetrieverCriteriaToRequest($this->entitySetRetrieverCriteriaMock);

        } catch (RequestSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitySetRetrieverCriteriaToRequest_withKeyname_Success() {

        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->firstKeynameName);
        $this->keynameHelper->expectsGetValue_Success($this->firstKeynameValue);

        $request = $this->adapter->fromEntitySetRetrieverCriteriaToRequest($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' where '.$this->firstKeynameName.' = :'.$this->firstKeynameName.';',
            'params' => [
                $this->firstKeynameName => $this->firstKeynameValue
            ]
        ], $request);

    }

    public function testFromEntitySetRetrieverCriteriaToRequest_withKeyname_withOrdering_Success() {

        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingHelper->expectsGetNames_Success($this->orderingNames);
        $this->orderingHelper->expectsIsAscending_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->firstKeynameName);
        $this->keynameHelper->expectsGetValue_Success($this->firstKeynameValue);

        $request = $this->adapter->fromEntitySetRetrieverCriteriaToRequest($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' where '.$this->firstKeynameName.' = :'.$this->firstKeynameName.$this->orderByQuery.';',
            'params' => [
                $this->firstKeynameName => $this->firstKeynameValue
            ]
        ], $request);

    }

    public function testFromEntitySetRetrieverCriteriaToRequest_withoutCriteria_throwsRequestSetException() {

        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromEntitySetRetrieverCriteriaToRequest($this->entitySetRetrieverCriteriaMock);

        } catch (RequestSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntitySetRequest_Success() {

        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_Success($this->entitySetRetrieverCriteriaMock, $this->setCriteria);
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuidsData);
        $this->uuidAdapterHelper->expectsFromUuidsToBinaryStrings_Success($this->uuids, $this->uuidsData);

        $request = $this->adapter->fromDataToEntitySetRequest($this->setCriteria);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' where uuid IN(:0, :1);',
            'params' => $this->uuids
        ], $request);

    }

    public function testFromDataToEntitySetRequest_throwsEntitySetException_throwsRequestSetException() {

        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_throwsEntitySetException($this->setCriteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntitySetRequest($this->setCriteria);

        } catch (RequestSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
