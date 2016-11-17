<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityPartialSetRepositoryHelper;

final class EntityPartialSetRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRepositoryMock;
    private $entityPartialSetMock;
    private $criteria;
    private $helper;
    public function setUp() {
        $this->entityPartialSetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository');
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');

        $this->criteria = [
            'container' => 'some_container',
            'index' => rand(0, 100),
            'amount' => rand(1, 100)
        ];

        $this->helper = new EntityPartialSetRepositoryHelper($this, $this->entityPartialSetRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->entityPartialSetMock, $this->criteria);

        $partialSet = $this->entityPartialSetRepositoryMock->retrieve($this->criteria);

        $this->assertEquals($this->entityPartialSetMock, $partialSet);

    }

    public function testRetrieve_throwsEntityPartialSetException() {

        $this->helper->expectsRetrieve_throwsEntityPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->entityPartialSetRepositoryMock->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
