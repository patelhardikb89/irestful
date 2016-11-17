<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters\TransformerAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTransformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteTransformerAdapter implements TransformerAdapter {
	public function __construct() {

	}

	public function fromDataToTransformer(array $data) {

		if (!isset($data['type'])) {
			throw new TransformerException('The type keyname is mandatory in order to convert data to a Transformer object.');
		}

		if (!isset($data['method_name'])) {
			throw new TransformerException('The method_name keyname is mandatory in order to convert data to a Transformer object.');
		}

		return new ConcreteTransformer($data['type'], $data['method_name']);

	}

}
