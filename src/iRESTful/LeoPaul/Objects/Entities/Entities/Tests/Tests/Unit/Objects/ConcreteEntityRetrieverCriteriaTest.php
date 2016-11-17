<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteEntityRetrieverCriteriaTest extends \PHPUnit_Framework_TestCase {
    private $uuidMock;
    private $keynameMock;
    private $containerName;
    public function setUp() {

        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->containerName = 'my_container';

    }

    public function tearDown() {

    }

    public function testCreate_withUuid_Success() {

        $criteria = new ConcreteEntityRetrieverCriteria($this->containerName, $this->uuidMock);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertTrue($criteria->hasUuid());
        $this->assertEquals($this->uuidMock, $criteria->getUuid());
        $this->assertFalse($criteria->hasKeyname());
        $this->assertNull($criteria->getKeyname());
        $this->assertFalse($criteria->hasKeynames());
        $this->assertNull($criteria->getKeynames());

    }

    public function testCreate_withKeyname_Success() {

        $criteria = new ConcreteEntityRetrieverCriteria($this->containerName, null, $this->keynameMock);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertFalse($criteria->hasUuid());
        $this->assertNull($criteria->getUuid());
        $this->assertTrue($criteria->hasKeyname());
        $this->assertEquals($this->keynameMock, $criteria->getKeyname());
        $this->assertFalse($criteria->hasKeynames());
        $this->assertNull($criteria->getKeynames());

    }

    public function testCreate_withKeynames_Success() {

        $criteria = new ConcreteEntityRetrieverCriteria($this->containerName, null, null, [$this->keynameMock]);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertFalse($criteria->hasUuid());
        $this->assertNull($criteria->getUuid());
        $this->assertFalse($criteria->hasKeyname());
        $this->assertNull($criteria->getKeyname());
        $this->assertTrue($criteria->hasKeynames());
        $this->assertEquals([$this->keynameMock], $criteria->getKeynames());

    }

    public function testCreate_withoutRetrieverCriteria_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntityRetrieverCriteria($this->containerName);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withMultipleRetrieverCriteria_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntityRetrieverCriteria($this->containerName, $this->uuidMock, $this->keynameMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withAllRetrieverCriteria_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntityRetrieverCriteria($this->containerName, $this->uuidMock, $this->keynameMock, [$this->keynameMock]);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyContainerName_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntityRetrieverCriteria('', $this->uuidMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
