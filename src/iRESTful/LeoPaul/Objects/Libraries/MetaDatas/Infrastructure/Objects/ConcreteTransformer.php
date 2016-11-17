<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteTransformer implements Transformer {
	private $type;
	private $methodName;
	public function __construct($type, $methodName) {

		if (empty($type) || !is_string($type)) {
			throw new TransformerException('The type must be a non-empty string.');
		}

		if (empty($methodName) || !is_string($methodName)) {
			throw new TransformerException('The methodName must be a non-empty string.');
		}

		if (!class_exists($type) && !interface_exists($type)) {
			throw new TransformerException('The given type ('.$type.') is not a valid interface or class.');
		}

		if (!method_exists($type, $methodName)) {
			throw new TransformerException('The method name ('.$methodName.') does not exists on the interface/class ('.$type.').');
		}

		$this->type = $type;
		$this->methodName = $methodName;
	}

	public function getType() {
		return $this->type;
	}

	public function getMethodName() {
		return $this->methodName;
	}

}
