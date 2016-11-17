<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Adapters\ClassMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Adapters\ConstructorMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConcreteClassMetaDataAdapter implements ClassMetaDataAdapter {
	private $constructorMetaDataAdapter;
	public function __construct(ConstructorMetaDataAdapter $constructorMetaDataAdapter) {
		$this->constructorMetaDataAdapter = $constructorMetaDataAdapter;
	}

	public function fromDataToClassMetaData(array $data) {

		if (!isset($data['arguments'])) {
			throw new ClassMetaDataException('The arguments keyname is mandatory in order to convert data to a ClassMetaData object.');
		}

		if (!isset($data['class'])) {
			throw new ClassMetaDataException('The class keyname is mandatory in order to convert data to a ClassMetaData object.');
		}

        $containerName = null;
		if (isset($data['container_name'])) {
			$containerName = $data['container_name'];
		}

		try {

			$arguments = $this->constructorMetaDataAdapter->fromDataToConstructorMetaDatas($data['arguments']);
			return new ConcreteClassMetaData($data['class'], $arguments, $containerName);

		} catch (ConstructorMetaDataException $exception) {
			throw new ClassMetaDataException('There was an exception while converting data to ConstructorMetaData objects.', $exception);
		}
	}

}
