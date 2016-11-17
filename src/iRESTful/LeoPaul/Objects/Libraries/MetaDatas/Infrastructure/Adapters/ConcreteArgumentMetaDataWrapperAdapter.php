<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\Adapters\ArgumentMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\Adapters\ArrayMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteArgumentMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ConcreteArgumentMetaDataWrapperAdapter implements ArgumentMetaDataWrapperAdapter {
	private $arrayMetaDataWrapperAdapter;
	public function __construct(ArrayMetaDataWrapperAdapter $arrayMetaDataWrapperAdapter) {
        $this->arrayMetaDataWrapperAdapter = $arrayMetaDataWrapperAdapter;
	}

	public function fromDataToArgumentMetaDataWrapper(array $data) {

		if (!isset($data['argument_meta_data'])) {
			throw new ArgumentMetaDataException('The argument_meta_data keyname is mandatory in order to convert data to an ArgumentMetaDataWrapper object.');
		}

		if (!isset($data['object_adapter'])) {
			throw new ArgumentMetaDataException('The object_adapter keyname is mandatory in order to convert data to an ArgumentMetaDataWrapper object.');
		}

		if (!isset($data['class'])) {
			throw new ArgumentMetaDataException('The class keyname is mandatory in order to convert data to an ArgumentMetaDataWrapper object.');
		}

		$callBackOnFail = (isset($data['callback_on_fail']) && !empty($data['callback_on_fail'])) ? $data['callback_on_fail'] : null;
		return new ConcreteArgumentMetaDataWrapper($data['object_adapter'], $this->arrayMetaDataWrapperAdapter, $data['argument_meta_data'], $data['class'], $callBackOnFail);

	}

}
