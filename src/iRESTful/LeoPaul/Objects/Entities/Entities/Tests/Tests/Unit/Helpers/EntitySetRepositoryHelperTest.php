<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntitySetRepositoryHelper;

final class EntitySetRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRepositoryMock;
    private $entityMock;
    private $entities;
    private $criteria;
    private $helper;
    public function setUp() {
        $this->entitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->criteria = [
            'container' => 'my_container',
            'uuids' => [
                '1c872c49-634e-40e4-9653-46034af16ebd',
                'f21b7309-bf4a-4f6e-bc7b-e9ef53daa844'
            ]
        ];

        $this->helper = new EntitySetRepositoryHelper($this, $this->entitySetRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->entities, $this->criteria);

        $entities = $this->entitySetRepositoryMock->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_throwsEntitySetException() {

        $this->helper->expectsRetrieve_throwsEntitySetException($this->criteria);

        $asserted = false;
        try {

            $this->entitySetRepositoryMock->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
