<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteTransformerWrapper;

final class ConcreteTransformerWrapperAdapter implements TransformerWrapperAdapter {
	private $transformerObjects;
	public function __construct(array $transformerObjects) {
		$this->transformerObjects = $transformerObjects;
	}

	public function fromTransformerToTransformerWrapper(Transformer $transformer) {
		return new ConcreteTransformerWrapper($this->transformerObjects, $transformer);
	}

}
