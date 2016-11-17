<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;

final class TransformerHelper {
	private $phpunit;
	private $transformerMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, Transformer $transformerMock) {
		$this->phpunit = $phpunit;
		$this->transformerMock = $transformerMock;
	}

	public function expectsGetType_Success($returnedType) {
		$this->transformerMock->expects($this->phpunit->once())
								->method('getType')
								->will($this->phpunit->returnValue($returnedType));
	}

	public function expectsGetMethodName_Success($returnedMethodName) {
		$this->transformerMock->expects($this->phpunit->once())
								->method('getMethodName')
								->will($this->phpunit->returnValue($returnedMethodName));
	}

}
