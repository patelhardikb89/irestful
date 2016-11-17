<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class ConcreteEntityRelationRetrieverCriteriaTest extends \PHPUnit_Framework_TestCase {
    private $uuidMock;
    private $masterContainerName;
    private $slaveContainerName;
    private $slavePropertyName;
    public function setUp() {
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->masterContainerName = 'roles';
        $this->slaveContainerName = 'permissions';
        $this->slavePropertyName = 'pernission';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $criteria = new ConcreteEntityRelationRetrieverCriteria($this->masterContainerName, $this->slaveContainerName, $this->slavePropertyName , $this->uuidMock);

        $this->assertEquals($this->masterContainerName, $criteria->getMasterContainerName());
        $this->assertEquals($this->slaveContainerName, $criteria->getSlaveContainerName());
        $this->assertEquals($this->slavePropertyName, $criteria->getSlavePropertyName());
        $this->assertEquals($this->uuidMock, $criteria->getMasterUuid());

    }

    public function testCreate_withNonStringMasterContainerName_throwsEntityRelationException() {

        $asserted = false;
        try {

            new ConcreteEntityRelationRetrieverCriteria(new \DateTime(), $this->slaveContainerName, $this->slavePropertyName , $this->uuidMock);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptyMasterContainerName_throwsEntityRelationException() {

        $asserted = false;
        try {

            new ConcreteEntityRelationRetrieverCriteria(new \DateTime(), $this->slaveContainerName, $this->slavePropertyName , $this->uuidMock);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withNonStringSlaveContainerName_throwsEntityRelationException() {

        $asserted = false;
        try {

            new ConcreteEntityRelationRetrieverCriteria($this->masterContainerName, new \DateTime(), $this->slavePropertyName , $this->uuidMock);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptySlaveContainerName_throwsEntityRelationException() {

        $asserted = false;
        try {

            new ConcreteEntityRelationRetrieverCriteria($this->masterContainerName, new \DateTime(), $this->slavePropertyName , $this->uuidMock);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withNonStringSlavePropertyName_throwsEntityRelationException() {

        $asserted = false;
        try {

            new ConcreteEntityRelationRetrieverCriteria($this->masterContainerName, $this->slaveContainerName, new \DateTime(), $this->uuidMock);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptySlavePropertyNamethrowsEntityRelationException() {

        $asserted = false;
        try {

            new ConcreteEntityRelationRetrieverCriteria($this->masterContainerName, $this->slaveContainerName, new \DateTime(), $this->uuidMock);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
