<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Adapters\ArrayMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteArrayMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters\TransformerAdapter;

final class ConcreteArrayMetaDataAdapter implements ArrayMetaDataAdapter {
    private $transformerAdapter;
	public function __construct(TransformerAdapter $transformerAdapter) {
        $this->transformerAdapter = $transformerAdapter;
	}

	public function fromDataToArrayMetaData(array $data) {

		$elementsType = null;
		if (isset($data['elements_type'])) {
			$elementsType = $data['elements_type'];
		}

        $toObjectTransformer = null;
        $toDataTransformer = null;
        if (isset($data['transformers']) && isset($data['transformers']['to_data_transformer']) && isset($data['transformers']['to_object_transformer'])) {
            $toDataTransformer = $this->transformerAdapter->fromDataToTransformer($data['transformers']['to_data_transformer']);
            $toObjectTransformer = $this->transformerAdapter->fromDataToTransformer($data['transformers']['to_object_transformer']);
        }

		return new ConcreteArrayMetaData($elementsType, $toObjectTransformer, $toDataTransformer);

	}

}
