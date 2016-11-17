<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\TransformerWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class TransformerWrapperAdapterHelper {
	private $phpunit;
	private $transformerWrapperAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, TransformerWrapperAdapter $transformerWrapperAdapterMock) {
		$this->phpunit = $phpunit;
		$this->transformerWrapperAdapterMock = $transformerWrapperAdapterMock;
	}

	public function expectsFromTransformerToTransformerWrapper_Success(TransformerWrapper $returnedTransformerWrapper, Transformer $transformer) {

		$this->transformerWrapperAdapterMock->expects($this->phpunit->once())
												->method('fromTransformerToTransformerWrapper')
												->with($transformer)
												->will($this->phpunit->returnValue($returnedTransformerWrapper));

	}
}
