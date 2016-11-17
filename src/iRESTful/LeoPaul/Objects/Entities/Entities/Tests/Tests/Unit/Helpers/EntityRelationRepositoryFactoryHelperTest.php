<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityRelationRepositoryFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class EntityRelationRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryFactoryMock;
    private $entityRelationRepositoryMock;
    private $helper;
    public function setUp() {
        $this->entityRelationRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');

        $this->helper = new EntityRelationRepositoryFactoryHelper($this, $this->entityRelationRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entityRelationRepositoryMock);

        $repository = $this->entityRelationRepositoryFactoryMock->create();

        $this->assertEquals($this->entityRelationRepositoryMock, $repository);

    }

    public function testCreate_throwsEntityRelationException() {

        $this->helper->expectsCreate_throwsEntityRelationException();

        $asserted = false;
        try {

            $this->entityRelationRepositoryFactoryMock->create();

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
