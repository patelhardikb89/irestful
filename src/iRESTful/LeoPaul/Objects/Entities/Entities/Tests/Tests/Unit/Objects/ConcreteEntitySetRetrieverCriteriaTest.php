<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class ConcreteEntitySetRetrieverCriteriaTest extends \PHPUnit_Framework_TestCase {
    private $keynameMock;
    private $orderingMock;
    private $uuidMock;
    private $uuids;
    private $invalidUuids;
    private $containerName;
    public function setUp() {
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->uuids = [$this->uuidMock];
        $this->invalidUuids = [$this->uuidMock, new \DateTime()];

        $this->containerName = 'my_container';
    }

    public function tearDown() {

    }

    public function testCreate_withKeyname_Success() {

        $criteria = new ConcreteEntitySetRetrieverCriteria($this->containerName, $this->keynameMock);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertTrue($criteria->hasKeyname());
        $this->assertEquals($this->keynameMock, $criteria->getKeyname());
        $this->assertFalse($criteria->hasUuids());
        $this->assertNull($criteria->getUuids());
        $this->assertFalse($criteria->hasOrdering());
        $this->assertNull($criteria->getOrdering());

    }

    public function testCreate_withKeyname_withOrdering_Success() {

        $criteria = new ConcreteEntitySetRetrieverCriteria($this->containerName, $this->keynameMock, null, $this->orderingMock);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertTrue($criteria->hasKeyname());
        $this->assertEquals($this->keynameMock, $criteria->getKeyname());
        $this->assertFalse($criteria->hasUuids());
        $this->assertNull($criteria->getUuids());
        $this->assertTrue($criteria->hasOrdering());
        $this->assertEquals($this->orderingMock, $criteria->getOrdering());

    }

    public function testCreate_withUuids_Success() {

        $criteria = new ConcreteEntitySetRetrieverCriteria($this->containerName, null, $this->uuids);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertFalse($criteria->hasKeyname());
        $this->assertNull($criteria->getKeyname());
        $this->assertTrue($criteria->hasUuids());
        $this->assertEquals($this->uuids, $criteria->getUuids());
        $this->assertFalse($criteria->hasOrdering());
        $this->assertNull($criteria->getOrdering());

    }

    public function testCreate_withUuids_withOrdering_Success() {

        $criteria = new ConcreteEntitySetRetrieverCriteria($this->containerName, null, $this->uuids, $this->orderingMock);

        $this->assertEquals($this->containerName, $criteria->getContainerName());
        $this->assertFalse($criteria->hasKeyname());
        $this->assertNull($criteria->getKeyname());
        $this->assertTrue($criteria->hasUuids());
        $this->assertEquals($this->uuids, $criteria->getUuids());
        $this->assertTrue($criteria->hasOrdering());
        $this->assertEquals($this->orderingMock, $criteria->getOrdering());

    }

    public function testCreate_withKeyname_withUuids_throwsEntitySetException() {

        $asserted = false;
        try {

            new ConcreteEntitySetRetrieverCriteria($this->containerName, $this->keynameMock, $this->uuids);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withUuids_withOneNonUuidObject_throwsEntitySetException() {

        $asserted = false;
        try {

            new ConcreteEntitySetRetrieverCriteria($this->containerName, null, $this->invalidUuids);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutKeyname_withoutUuids_throwsEntitySetException() {

        $asserted = false;
        try {

            new ConcreteEntitySetRetrieverCriteria($this->containerName);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withUuids_withEmptyContainerName_throwsEntitySetException() {

        $asserted = false;
        try {

            new ConcreteEntitySetRetrieverCriteria('', null, $this->uuids);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withUuids_withNonStringContainerName_throwsEntitySetException() {

        $asserted = false;
        try {

            new ConcreteEntitySetRetrieverCriteria(new \DateTime(), null, $this->uuids);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
