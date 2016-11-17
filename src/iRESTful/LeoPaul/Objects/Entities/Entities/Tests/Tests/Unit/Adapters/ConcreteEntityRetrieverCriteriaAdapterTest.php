<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use  iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\KeynameAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteEntityRetrieverCriteriaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $uuidAdapterMock;
    private $uuidMock;
    private $keynameAdapterMock;
    private $keynameMock;
    private $containerName;
    private $keynameData;
    private $keynamesData;
    private $dataWithUuid;
    private $dataWithKeyname;
    private $dataWithKeynames;
    private $adapter;
    private $uuidAdapterHelper;
    private $keynameAdapterHelper;
    public function setUp() {
        $this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->keynameAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters\KeynameAdapter');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->containerName = 'my_container';

        $this->keynameData = [
            'name' => 'slug',
            'value' => 'this-is-a-slug'
        ];

        $this->keynamesData = [
            $this->keynameData,
            $this->keynameData
        ];

        $this->dataWithUuid = [
            'container' => $this->containerName,
            'uuid' => '0dde103a-6564-499d-beed-54099dcb632b'
        ];

        $this->dataWithKeyname = [
            'container' => $this->containerName,
            'keyname' => $this->keynameData
        ];

        $this->dataWithKeynames = [
            'container' => $this->containerName,
            'keynames' => $this->keynamesData
        ];

        $this->adapter = new ConcreteEntityRetrieverCriteriaAdapter($this->uuidAdapterMock, $this->keynameAdapterMock);

        $this->uuidAdapterHelper = new UuidAdapterHelper($this, $this->uuidAdapterMock);
        $this->keynameAdapterHelper = new KeynameAdapterHelper($this, $this->keynameAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToRetrieverCriteria_Success() {

        $this->uuidAdapterHelper->expectsFromStringToUuid_Success($this->uuidMock, $this->dataWithUuid['uuid']);

        $retrieverCriteria = $this->adapter->fromDataToRetrieverCriteria($this->dataWithUuid);

        $this->assertEquals($this->containerName, $retrieverCriteria->getContainerName());
        $this->assertTrue($retrieverCriteria->hasUuid());
        $this->assertEquals($this->uuidMock, $retrieverCriteria->getUuid());
        $this->assertFalse($retrieverCriteria->hasKeyname());
        $this->assertNull($retrieverCriteria->getKeyname());
        $this->assertFalse($retrieverCriteria->hasKeynames());
        $this->assertNull($retrieverCriteria->getKeynames());

    }

    public function testFromDataToRetrieverCriteria_throwsUuidException_throwsEntityException() {

        $this->uuidAdapterHelper->expectsFromStringToUuid_throwsUuidException($this->dataWithUuid['uuid']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRetrieverCriteria($this->dataWithUuid);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRetrieverCriteria_withKeyname_Success() {

        $this->keynameAdapterHelper->expectsFromDataToKeyname_Success($this->keynameMock, $this->dataWithKeyname['keyname']);

        $retrieverCriteria = $this->adapter->fromDataToRetrieverCriteria($this->dataWithKeyname);

        $this->assertEquals($this->containerName, $retrieverCriteria->getContainerName());
        $this->assertFalse($retrieverCriteria->hasUuid());
        $this->assertNull($retrieverCriteria->getUuid());
        $this->assertTrue($retrieverCriteria->hasKeyname());
        $this->assertEquals($this->keynameMock, $retrieverCriteria->getKeyname());
        $this->assertFalse($retrieverCriteria->hasKeynames());
        $this->assertNull($retrieverCriteria->getKeynames());

    }

    public function testFromDataToRetrieverCriteria_throwsKeynameException_throwsEntityException() {

        $this->keynameAdapterHelper->expectsFromDataToKeyname_throwsKeynameException($this->dataWithKeyname['keyname']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRetrieverCriteria($this->dataWithKeyname);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRetrieverCriteria_withKeynames_Success() {

        $this->keynameAdapterHelper->expectsFromDataToKeynames_Success([$this->keynameMock, $this->keynameMock], $this->dataWithKeynames['keynames']);

        $retrieverCriteria = $this->adapter->fromDataToRetrieverCriteria($this->dataWithKeynames);

        $this->assertEquals($this->containerName, $retrieverCriteria->getContainerName());
        $this->assertFalse($retrieverCriteria->hasUuid());
        $this->assertNull($retrieverCriteria->getUuid());
        $this->assertFalse($retrieverCriteria->hasKeyname());
        $this->assertNull($retrieverCriteria->getKeyname());
        $this->assertTrue($retrieverCriteria->hasKeynames());
        $this->assertEquals([$this->keynameMock, $this->keynameMock], $retrieverCriteria->getKeynames());

    }

    public function testFromDataToRetrieverCriteria_throwsKeynameException_withKeynames_throwsEntityException() {

        $this->keynameAdapterHelper->expectsFromDataToKeynames_throwsKeynameException($this->dataWithKeynames['keynames']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRetrieverCriteria($this->dataWithKeynames);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRetrieverCriteria_withoutContainers_throwsEntityException() {

        $asserted = false;
        try {

            unset($this->dataWithKeynames['container']);
            $this->adapter->fromDataToRetrieverCriteria($this->dataWithKeynames);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRetrieverCriteria_withoutRetrieverCriteria_throwsEntityException() {

        $asserted = false;
        try {

            unset($this->dataWithKeynames['keynames']);
            $this->adapter->fromDataToRetrieverCriteria($this->dataWithKeynames);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
