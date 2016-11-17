<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\TransformerWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteTransformerWrapper implements TransformerWrapper {
	private $transformerObjects;
	private $transformer;
	public function __construct(array $transformerObjects, Transformer $transformer) {
		$this->transformerObjects = $transformerObjects;
		$this->transformer = $transformer;
	}

	public function transform($input) {

        if (is_null($input)) {
            return null;
        }

		$type = $this->transformer->getType();
		if (!isset($this->transformerObjects[$type])) {
			throw new TransformerException('The transformer type ('.$type.') does not exists in the transformer objects.');
		}

		$methodName = $this->transformer->getMethodName();
		if (!method_exists($this->transformerObjects[$type], $methodName)) {
			throw new TransformerException('The methodName ('.$methodName.') does not exists on type: '.$type);
		}

		try {

			return $this->transformerObjects[$type]->$methodName($input);

		} catch (\Exception $exception) {
			throw new TransformerException('There was an exception while transforming an element/data using this service: '.$type.'::'.$methodName);
		}
	}

}
