<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ConcreteClassMetaData implements ClassMetaData {
	private $arguments;
	private $type;
	private $containerName;
	public function __construct($type, array $arguments, $containerName = null) {

		if (empty($containerName)) {
			$containerName = null;
		}

		if (empty($type) || !is_string($type)) {
			throw new ClassMetaDataException('The type must be a non-empty string.');
		}

		if (!class_exists($type) && !interface_exists($type)) {
			throw new ClassMetaDataException('The type ('.$type.') must is not a valid class or interface.');
		}

		if (!empty($containerName) && !is_string($containerName)) {
			throw new ClassMetaDataException('The containerName must be a string if non-empty.');
		}

		foreach($arguments as $oneArgument) {
			if (!is_object($oneArgument) || !($oneArgument instanceof ConstructorMetaData)) {
				throw new ClassMetaDataException('At least 1 element inside the argument array is not an ConstructorMetaData object.');
			}
		}

		$this->type = $type;
		$this->containerName = $containerName;
		$this->arguments = $arguments;
	}

	public function getType() {
		return $this->type;
	}

	public function getArguments() {
		return $this->arguments;
	}

	public function hasContainerName() {
		return !empty($this->containerName);
	}

	public function getContainerName() {
		return $this->containerName;
	}
}
