<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\SubEntityRepositoryFactoryHelper;

final class SubEntityRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $subEntityRepositoryFactoryMock;
    private $subEntityRepositoryMock;
    private $helper;
    public function setUp() {
        $this->subEntityRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\Factories\SubEntityRepositoryFactory');
        $this->subEntityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository');

        $this->helper = new SubEntityRepositoryFactoryHelper($this, $this->subEntityRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->subEntityRepositoryMock);

        $repository = $this->subEntityRepositoryFactoryMock->create();

        $this->assertEquals($this->subEntityRepositoryMock, $repository);

    }

}
