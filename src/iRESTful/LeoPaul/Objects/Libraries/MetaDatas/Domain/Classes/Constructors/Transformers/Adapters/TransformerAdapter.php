<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters;

interface TransformerAdapter {
	public function fromDataToTransformer(array $data);
}
