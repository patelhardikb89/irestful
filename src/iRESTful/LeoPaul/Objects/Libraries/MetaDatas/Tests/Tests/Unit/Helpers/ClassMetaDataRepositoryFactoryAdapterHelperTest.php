<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\ClassMetaDataRepositoryFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ClassMetaDataRepositoryFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $classMetaDataRepositoryFactoryAdapterMock;
    private $classMetaDataRepositoryFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->classMetaDataRepositoryFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\Adapters\ClassMetaDataRepositoryFactoryAdapter');
        $this->classMetaDataRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\ClassMetaDataRepositoryFactory');

        $this->data = [
            'some' => 'input'
        ];

        $this->helper = new ClassMetaDataRepositoryFactoryAdapterHelper($this, $this->classMetaDataRepositoryFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToClassMetaDataRepositoryFactory_Success() {

        $this->helper->expectsFromDataToClassMetaDataRepositoryFactory_Success($this->classMetaDataRepositoryFactoryMock, $this->data);

        $factory = $this->classMetaDataRepositoryFactoryAdapterMock->fromDataToClassMetaDataRepositoryFactory($this->data);

        $this->assertEquals($this->classMetaDataRepositoryFactoryMock, $factory);

    }

    public function testFromDataToClassMetaDataRepositoryFactory_throwsClassMetaDataException() {

        $this->helper->expectsFromDataToClassMetaDataRepositoryFactory_throwsClassMetaDataException($this->data);

        $asserted = false;
        try {

            $this->classMetaDataRepositoryFactoryAdapterMock->fromDataToClassMetaDataRepositoryFactory($this->data);

        } catch (ClassMetaDataException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
