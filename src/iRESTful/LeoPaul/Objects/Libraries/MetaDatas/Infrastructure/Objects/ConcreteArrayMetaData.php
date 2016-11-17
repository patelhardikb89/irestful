<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ConcreteArrayMetaData implements ArrayMetaData {
    private $toObjectTransformer;
    private $toDataTransformer;
	private $elementsType;
	public function __construct($elementsType = null, Transformer $toObjectTransformer = null, Transformer $toDataTransformer = null) {

		if (empty($elementsType)) {
			$elementsType = null;
		}

		if (!empty($elementsType) && !is_string($elementsType)) {
			throw new ArrayMetaDataException('The elementsType must be a string if non-empty.');
		}

		if (!empty($elementsType) && !class_exists($elementsType) && !interface_exists($elementsType)) {
			throw new ArrayMetaDataException('The elementsType must be a valid interface or class if non-empty.');
		}

        $amount = (empty($toObjectTransformer) ? 0 : 1) + (empty($toDataTransformer) ? 0 : 1);
        if (($amount != 0) && ($amount != 2)) {
            throw new ArrayMetaDataException('The transformers must either be there or not there.  You cannot just have 1 transformer set.');
        }

		$this->elementsType = $elementsType;
        $this->toObjectTransformer = $toObjectTransformer;
        $this->toDataTransformer = $toDataTransformer;

	}

	public function hasElementsType() {
		return !empty($this->elementsType);
	}

	public function getElementsType() {
		return $this->elementsType;
	}

    public function hasTransformers() {
        return !empty($this->toObjectTransformer) && !empty($this->toDataTransformer);
    }

    public function getToObjectTransformer() {
        return $this->toObjectTransformer;
    }

    public function getToDataTransformer() {
        return $this->toDataTransformer;
    }

}
