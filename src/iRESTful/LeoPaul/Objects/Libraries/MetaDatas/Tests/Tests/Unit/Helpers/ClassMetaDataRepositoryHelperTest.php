<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Repositories\ClassMetaDataRepositoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ClassMetaDataRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $classMetaDataRepositoryMock;
    private $classMetaDataMock;
    private $criteria;
    private $helper;
    public function setUp() {
        $this->classMetaDataRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository');
        $this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');

        $this->criteria = [
            'some' => 'criteria'
        ];

        $this->helper = new ClassMetaDataRepositoryHelper($this, $this->classMetaDataRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->classMetaDataMock, $this->criteria);

        $classMetaData = $this->classMetaDataRepositoryMock->retrieve($this->criteria);

        $this->assertEquals($this->classMetaDataMock, $classMetaData);

    }

    public function testRetrieve_throwsClassMetaDataException() {

        $this->helper->expectsRetrieve_throwsClassMetaDataException($this->criteria);

        $asserted = false;
        try {

            $this->classMetaDataRepositoryMock->retrieve($this->criteria);

        } catch (ClassMetaDataException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
