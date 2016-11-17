<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;

interface TransformerWrapperAdapter {
	public function fromTransformerToTransformerWrapper(Transformer $transformer);
}
