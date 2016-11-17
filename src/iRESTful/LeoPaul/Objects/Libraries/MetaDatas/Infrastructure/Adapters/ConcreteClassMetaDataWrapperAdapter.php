<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Wrappers\Adapters\ClassMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\Adapters\ConstructorMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteClassMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ConcreteClassMetaDataWrapperAdapter implements ClassMetaDataWrapperAdapter {
	private $constructorMetaDataWrapperAdapter;
	public function __construct(ConstructorMetaDataWrapperAdapter $constructorMetaDataWrapperAdapter) {
		$this->constructorMetaDataWrapperAdapter = $constructorMetaDataWrapperAdapter;
	}

	public function fromDataToClassMetaDataWrapper(array $data) {

		if (!isset($data['class_meta_data'])) {
			throw new ClassMetaDataException('The class_meta_data keyname is mandatory in order to convert data to a ClassMetaDataWrapper object.');
		}

		if (!isset($data['object_adapter'])) {
			throw new ClassMetaDataException('The object_adapter keyname is mandatory in order to convert data to a ClassMetaDataWrapper object.');
		}

		if (!isset($data['class'])) {
			throw new ClassMetaDataException('The class keyname is mandatory in order to convert data to a ClassMetaDataWrapper object.');
		}

		$callBackOnFail = (isset($data['callback_on_fail']) && !empty($data['callback_on_fail'])) ? $data['callback_on_fail'] : null;
		return new ConcreteClassMetaDataWrapper($data['object_adapter'], $this->constructorMetaDataWrapperAdapter, $data['class_meta_data'], $data['class'], $callBackOnFail);

	}

}
