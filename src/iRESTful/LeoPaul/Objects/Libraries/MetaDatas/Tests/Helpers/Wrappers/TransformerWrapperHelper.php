<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\TransformerWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class TransformerWrapperHelper {
	private $phpunit;
	private $transformerWrapperMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, TransformerWrapper $transformerWrapperMock) {
		$this->phpunit = $phpunit;
		$this->transformerWrapperMock = $transformerWrapperMock;
	}

	public function expectsTransform_Success($returnedTransformedObject, $input) {
		$this->transformerWrapperMock->expects($this->phpunit->once())
										->method('transform')
										->with($input)
										->will($this->phpunit->returnValue($returnedTransformedObject));
	}

	public function expectsTransform_throwsTransformerException($input) {
		$this->transformerWrapperMock->expects($this->phpunit->once())
										->method('transform')
										->with($input)
										->will($this->phpunit->throwException(new TransformerException('TEST')));
	}

}
