<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\Adapters\ArrayMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteArrayMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;

final class ConcreteArrayMetaDataWrapperAdapter implements ArrayMetaDataWrapperAdapter {
    private $transformerWrapperAdapter;
	public function __construct(TransformerWrapperAdapter $transformerWrapperAdapter) {
        $this->transformerWrapperAdapter = $transformerWrapperAdapter;
	}

	public function fromDataToArrayMetaDataWrapper(array $data) {

		if (!isset($data['array_meta_data'])) {
			throw new ArrayMetaDataException('The array_meta_data keyname is mandatory in order to convert data to an ArrayMetaDataWrapper object.');
		}

		if (!isset($data['object_adapter'])) {
			throw new ArrayMetaDataException('The object_adapter keyname is mandatory in order to convert data to an ArrayMetaDataWrapper object.');
		}

		$callBackOnFail = (isset($data['callback_on_fail']) && !empty($data['callback_on_fail'])) ? $data['callback_on_fail'] : null;
		return new ConcreteArrayMetaDataWrapper($this->transformerWrapperAdapter, $data['object_adapter'], $data['array_meta_data'], $callBackOnFail);

	}

}
