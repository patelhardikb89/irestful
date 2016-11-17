<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Factories\ClassMetaDataRepositoryFactoryHelper;

final class ClassMetaDataRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $classMetaDataRepositoryFactoryMock;
    private $classMetaDataRepositoryMock;
    private $helper;
    public function setUp() {
        $this->classMetaDataRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\ClassMetaDataRepositoryFactory');
        $this->classMetaDataRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository');

        $this->helper = new ClassMetaDataRepositoryFactoryHelper($this, $this->classMetaDataRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->classMetaDataRepositoryMock);

        $repository = $this->classMetaDataRepositoryFactoryMock->create();

        $this->assertEquals($this->classMetaDataRepositoryMock, $repository);

    }

}
