<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\SubEntitySetRepositoryFactoryHelper;

final class SubEntitySetRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $subEntitySetRepositoryFactoryMock;
    private $subEntitySetRepositoryMock;
    private $helper;
    public function setUp() {
        $this->subEntitySetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\Factories\SubEntitySetRepositoryFactory');
        $this->subEntitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository');

        $this->helper = new SubEntitySetRepositoryFactoryHelper($this, $this->subEntitySetRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->subEntitySetRepositoryMock);

        $repository = $this->subEntitySetRepositoryFactoryMock->create();

        $this->assertEquals($this->subEntitySetRepositoryMock, $repository);

    }

}
