<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\Adapters\ConstructorMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\Adapters\ArgumentMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteConstructorMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConcreteConstructorMetaDataWrapperAdapter implements ConstructorMetaDataWrapperAdapter {
	private $argumentMetaDataWrapperAdapter;
	private $transformerWrapperAdapter;
	private $delimiter;
	public function __construct(ArgumentMetaDataWrapperAdapter $argumentMetaDataWrapperAdapter, TransformerWrapperAdapter $transformerWrapperAdapter, $delimiter) {
		$this->argumentMetaDataWrapperAdapter = $argumentMetaDataWrapperAdapter;
		$this->transformerWrapperAdapter = $transformerWrapperAdapter;
		$this->delimiter = $delimiter;
	}

	public function fromDataToConstructorMetaDataWrapper(array $data) {

		if (!isset($data['constructor_meta_data'])) {
			throw new ConstructorMetaDataException('The constructor_meta_data keyname is mandatory in order to convert data to a ConstructorMetaDataWrapper object.');
		}

		if (!isset($data['object_adapter'])) {
			throw new ConstructorMetaDataException('The object_adapter keyname is mandatory in order to convert data to a ConstructorMetaDataWrapper object.');
		}

		if (!isset($data['class'])) {
			throw new ConstructorMetaDataException('The class keyname is mandatory in order to convert data to a ConstructorMetaDataWrapper object.');
		}

		$callBackOnFail = (isset($data['callback_on_fail']) && !empty($data['callback_on_fail'])) ? $data['callback_on_fail'] : null;
		return new ConcreteConstructorMetaDataWrapper($data['object_adapter'], $this->argumentMetaDataWrapperAdapter, $this->transformerWrapperAdapter, $data['constructor_meta_data'], $data['class'], $this->delimiter, $callBackOnFail);

	}

}
