<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRelationRepositoryHelper;

final class EntityRelationRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryMock;
    private $entityMock;
    private $entities;
    private $criteria;
    private $helper;
    public function setUp() {
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->criteria = [
            'master_container' => 'roles',
            'slave_container' => 'permissions',
            'slave_property' => 'permission',
            'master_uuid' => '78cee3ca-4b4e-4bb4-9c12-932c6faf6129'
        ];

        $this->helper = new EntityRelationRepositoryHelper($this, $this->entityRelationRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->entities, $this->criteria);

        $entities = $this->entityRelationRepositoryMock->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_throwsEntityRelationException() {

        $this->helper->expectsRetrieve_throwsEntityRelationException($this->criteria);

        $asserted = false;
        try {

            $this->entityRelationRepositoryMock->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
