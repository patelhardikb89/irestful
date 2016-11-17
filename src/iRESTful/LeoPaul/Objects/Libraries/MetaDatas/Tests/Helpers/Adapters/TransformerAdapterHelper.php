<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters\TransformerAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class TransformerAdapterHelper {
	private $phpunit;
	private $transformerAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, TransformerAdapter $transformerAdapterMock) {
		$this->phpunit = $phpunit;
		$this->transformerAdapterMock = $transformerAdapterMock;
	}

	public function expectsFromDataToTransformer_Success(Transformer $returnedTransformer, array $data) {
		$this->transformerAdapterMock->expects($this->phpunit->once())
										->method('fromDataToTransformer')
										->with($data)
										->will($this->phpunit->returnValue($returnedTransformer));
	}

	public function expectsFromDataToTransformer_multiple_Success(array $returnedTransformer, array $data) {
		foreach($returnedTransformer as $index => $oneReturnedTransformer) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('fromDataToTransformer')
							->with($data[$index])
                            ->will($this->phpunit->returnValue($returnedTransformer));
        }
	}

	public function expectsFromDataToTransformer_throwsTransformerException(array $data) {
		$this->transformerAdapterMock->expects($this->phpunit->once())
										->method('fromDataToTransformer')
										->with($data)
										->will($this->phpunit->throwException(new TransformerException('TEST')));
	}

}
