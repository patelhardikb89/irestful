<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ConcreteArgumentMetaData implements ArgumentMetaData {
	private $name;
	private $position;
	private $isOptional;
	private $isRecursive;
	private $arrayMetaData;
	private $classMetaData;
	public function __construct($name, $position, $isOptional, $isRecursive, ArrayMetaData $arrayMetaData = null, ClassMetaData $classMetaData = null) {

		$isOptional = (bool) $isOptional;
		$isRecursive = (bool) $isRecursive;
		$position = (int) $position;

		if (empty($name) || !is_string($name)) {
			throw new ArgumentMetaDataException('The name must be a non-empty string.');
		}

		if ($position < 0) {
			throw new ArgumentMetaDataException('The position must be an integer greater or equal to 0.');
		}

		if ($isRecursive && !empty($classMetaData)) {
			throw new ArgumentMetaDataException('isResursive cannot be true if a classMetaData is provided.');
		}

		$this->name = $name;
		$this->position = $position;
		$this->isOptional = $isOptional;
		$this->isRecursive = $isRecursive;
		$this->arrayMetaData = $arrayMetaData;
		$this->classMetaData = $classMetaData;
	}

	public function getName() {
		return $this->name;
	}

	public function getPosition() {
		return $this->position;
	}

	public function hasClassMetaData() {
		return !empty($this->classMetaData);
	}

	public function getClassMetaData() {
		return $this->classMetaData;
	}

	public function isOptional() {
		return $this->isOptional;
	}

	public function	isRecursive() {
		return $this->isRecursive;
	}

	public function hasArrayMetaData() {
		return !empty($this->arrayMetaData);
	}

	public function getArrayMetaData() {
		return $this->arrayMetaData;
	}

}
