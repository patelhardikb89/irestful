<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;

final class ConcreteConstructorMetaData implements ConstructorMetaData {
	private $argumentMetaData;
    private $isKey;
    private $isUnique;
	private $methodName;
	private $keyname;
	private $humanMethodName;
	private $transformer;
	private $type;
    private $default;
	public function __construct(ArgumentMetaData $argumentMetaData, $isKey, $isUnique, $methodName, $keyname, $humanMethodName = null, Transformer $transformer = null, $default = null, Type $type = null) {

		if (empty($humanMethodName)) {
			$humanMethodName = null;
		}

        if (!is_bool($isKey)) {
            throw new ConstructorMetaDataException('isKey must be a boolean.');
        }

        if (!is_bool($isUnique)) {
            throw new ConstructorMetaDataException('isUnique must be a boolean.');
        }

        if (is_object($default) || is_array($default)) {
            throw new ConstructorMetaDataException('The default cannot be an array or an object.');
        }

		if (empty($methodName) || !is_string($methodName)) {
			throw new ConstructorMetaDataException('The methodName must be a non-empty string.');
		}

		if (empty($keyname) || !is_string($keyname)) {
			throw new ConstructorMetaDataException('The keyname must be a non-empty string.');
		}

		if (!empty($humanMethodName) && !is_string($humanMethodName)) {
			throw new ConstructorMetaDataException('The humanMethodName must be a string if non-empty.');
		}

		$this->argumentMetaData = $argumentMetaData;
        $this->isKey = $isKey;
        $this->isUnique = ($isKey) ? true : $isUnique;
		$this->methodName = $methodName;
		$this->keyname = $keyname;
		$this->humanMethodName = $humanMethodName;
		$this->transformer = $transformer;
        $this->default = $default;
        $this->type = $type;
	}

	public function getArgumentMetaData() {
		return $this->argumentMetaData;
	}
    
	public function getMethodName() {
		return $this->methodName;
	}

	public function getKeyname() {
		return $this->keyname;
	}

    public function isKey() {
        return $this->isKey;
    }

    public function isUnique() {
        return $this->isUnique;
    }

	public function hasHumanMethodName() {
		return !empty($this->humanMethodName);
	}

	public function getHumanMethodName() {
		return $this->humanMethodName;
	}

	public function hasTransformer() {
		return !empty($this->transformer);
	}

	public function getTransformer() {
		return $this->transformer;
	}

    public function hasDefault() {
        return !is_null($this->default);
    }

    public function getDefault() {
        return $this->default;
    }

    public function hasType() {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }
}
