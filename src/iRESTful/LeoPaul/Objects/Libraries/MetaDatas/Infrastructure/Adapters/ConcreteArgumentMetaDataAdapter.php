<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Adapters\ArgumentMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Adapters\ArrayMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ConcreteArgumentMetaDataAdapter implements ArgumentMetaDataAdapter {
	private $arrayMetaDataAdapter;
	public function __construct(ArrayMetaDataAdapter $arrayMetaDataAdapter) {
		$this->arrayMetaDataAdapter = $arrayMetaDataAdapter;
	}

	public function fromDataToArgumentMetaData(array $data) {

		if (!isset($data['name'])) {
			throw new ArgumentMetaDataException('The name keyname is mandatory in order to convert data to an ArgumentMetaData object.');
		}

		if (!isset($data['position'])) {
			throw new ArgumentMetaDataException('The position keyname is mandatory in order to convert data to an ArgumentMetaData object.');
		}

		try {

			$classMetaData = null;
			if (isset($data['class_meta_data'])) {
				$classMetaData = $data['class_meta_data'];
			}

			$isRecursive = false;
			if (isset($data['is_recursive'])) {
				$isRecursive = (bool) $data['is_recursive'];
			}

			$isOptional = false;
			if (isset($data['is_optional'])) {
				$isOptional = (bool) $data['is_optional'];
			}

			$arrayMetaData = null;
			if (isset($data['array_meta_data'])) {
				$arrayMetaData = $this->arrayMetaDataAdapter->fromDataToArrayMetaData($data['array_meta_data']);
			}

			$position = (int) $data['position'];
			return new ConcreteArgumentMetaData($data['name'], $position, $isOptional, $isRecursive, $arrayMetaData, $classMetaData);

		} catch (ArrayMetaDataException $exception) {
			throw new ArgumentMetaDataException('There was an exception while converting data to an ArrayMetaData object.', $exception);
		}

	}

}
