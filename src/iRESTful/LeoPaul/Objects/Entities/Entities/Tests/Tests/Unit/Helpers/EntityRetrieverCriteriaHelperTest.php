<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRetrieverCriteriaHelper;

final class EntityRetrieverCriteriaHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRetrieverCriteriaMock;
    private $uuidMock;
    private $keynameMock;
    private $keynames;
    private $containerName;
    private $helper;
    public function setUp() {
        $this->entityRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->keynames = [
            $this->keynameMock,
            $this->keynameMock
        ];

        $this->containerName = 'my_container';

        $this->helper = new EntityRetrieverCriteriaHelper($this, $this->entityRetrieverCriteriaMock );
    }

    public function tearDown() {

    }

    public function testGetContainerName_Success() {

        $this->helper->expectsGetContainerName_Success($this->containerName);

        $containerName = $this->entityRetrieverCriteriaMock->getContainerName();

        $this->assertEquals($this->containerName, $containerName);

    }

    public function testHasUuid_Success() {

        $this->helper->expectsHasUuid_Success(false);

        $hasUuid = $this->entityRetrieverCriteriaMock->hasUuid();

        $this->assertFalse($hasUuid);

    }

    public function testGetUuid_Success() {

        $this->helper->expectsGetUuid_Success($this->uuidMock);

        $uuid = $this->entityRetrieverCriteriaMock->getUuid();

        $this->assertEquals($this->uuidMock, $uuid);

    }

    public function testHasKeyname_Success() {

        $this->helper->expectsHasKeyname_Success(true);

        $hasKeyname = $this->entityRetrieverCriteriaMock->hasKeyname();

        $this->assertTrue($hasKeyname);

    }

    public function testGetKeyname_Success() {

        $this->helper->expectsGetKeyname_Success($this->keynameMock);

        $keyname = $this->entityRetrieverCriteriaMock->getKeyname();

        $this->assertEquals($this->keynameMock, $keyname);

    }

    public function testHasKeynames_Success() {

        $this->helper->expectsHasKeynames_Success(false);

        $hasKeynames = $this->entityRetrieverCriteriaMock->hasKeynames();

        $this->assertFalse($hasKeynames);

    }

    public function testGetKeynames_Success() {

        $this->helper->expectsGetKeynames_Success($this->keynames);

        $keynames = $this->entityRetrieverCriteriaMock->getKeynames();

        $this->assertEquals($this->keynames, $keynames);

    }

}
