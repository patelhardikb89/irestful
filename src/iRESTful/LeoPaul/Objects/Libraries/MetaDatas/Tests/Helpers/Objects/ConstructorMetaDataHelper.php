<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;

final class ConstructorMetaDataHelper {
	private $phpunit;
	private $constructorMetaDataMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ConstructorMetaData $constructorMetaDataMock) {
		$this->phpunit = $phpunit;
		$this->constructorMetaDataMock = $constructorMetaDataMock;
	}

	public function expectsGetArgumentMetaData_Success(ArgumentMetaData $returnedArgumentMetaData) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getArgumentMetaData')
										->will($this->phpunit->returnValue($returnedArgumentMetaData));
	}

	public function expectsGetArgumentMetaData_multiple_Success(array $returnedArgumentMetaDatas) {

		foreach($returnedArgumentMetaDatas as $index => $oneReturnedArgumentMetaDatas) {
            $this->constructorMetaDataMock->expects($this->phpunit->at($index))
				                            ->method('getArgumentMetaData')
				                            ->will($this->phpunit->returnValue($oneReturnedArgumentMetaDatas));
        }
	}

	public function expectsGetMethodName_Success($returnedMethodName) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getMethodName')
										->will($this->phpunit->returnValue($returnedMethodName));
	}

	public function expectsGetKeyname_Success($returnedKeyname) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getKeyname')
										->will($this->phpunit->returnValue($returnedKeyname));
	}

	public function expectsHasHumanMethodName_Success($returnedBoolean) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('hasHumanMethodName')
										->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsGetHumanMethodName_Success($returnedHumanMethodName) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getHumanMethodName')
										->will($this->phpunit->returnValue($returnedHumanMethodName));
	}

	public function expectsHasTransformer_Success($returnedBoolean) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('hasTransformer')
										->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsGetTransformer_Success(Transformer $returnedTransformer) {
		$this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getTransformer')
										->will($this->phpunit->returnValue($returnedTransformer));
	}

    public function expectsIsKey_Success($returnedBoolean) {
        $this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('isKey')
										->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsIsKey_multiple_Success(array $returnedBooleans) {
        foreach($returnedBooleans as $index => $oneBoolean) {
            $this->constructorMetaDataMock->expects($this->phpunit->at($index))
				                            ->method('isKey')
				                            ->will($this->phpunit->returnValue($oneBoolean));
        }
    }

    public function expectsHasType_Success($returnedBoolean) {
        $this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('hasType')
										->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsIsUnique_Success($returnedBoolean) {
        $this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('isUnique')
										->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetType_Success(Type $returnedType) {
        $this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getType')
										->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsHasDefault_Success($returnedBoolean) {
        $this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('hasDefault')
										->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetDefault_Success($returnedDefault) {
        $this->constructorMetaDataMock->expects($this->phpunit->once())
										->method('getDefault')
										->will($this->phpunit->returnValue($returnedDefault));
    }

}
