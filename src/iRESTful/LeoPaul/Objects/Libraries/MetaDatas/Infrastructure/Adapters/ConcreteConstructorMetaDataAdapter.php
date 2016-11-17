<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Adapters\ConstructorMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Adapters\ArgumentMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Adapters\TransformerAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Adapters\TypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteConstructorMetaDataAdapter implements ConstructorMetaDataAdapter {
    private $typeAdapter;
	private $argumentMetaDataAdapter;
	private $transformerAdapter;
	public function __construct(TypeAdapter $typeAdapter, ArgumentMetaDataAdapter $argumentMetaDataAdapter, TransformerAdapter $transformerAdapter) {
        $this->typeAdapter = $typeAdapter;
        $this->argumentMetaDataAdapter = $argumentMetaDataAdapter;
		$this->transformerAdapter = $transformerAdapter;
	}

	public function fromDataToConstructorMetaDatas(array $data) {
		$output = [];
		foreach($data as $keyname => $oneData) {
			$output[$keyname] = $this->fromDataToConstructorMetaData($oneData);
		}

		return $output;
	}

	public function fromDataToConstructorMetaData(array $data) {

		if (!isset($data['argument_meta_data'])) {
			throw new ConstructorMetaDataException('The argument_meta_data keyname is mandatory in order to convert data to a ConstructorMetaData object.');
		}

		if (!isset($data['method_name'])) {
			throw new ConstructorMetaDataException('The method_name keyname is mandatory in order to convert data to a ConstructorMetaData object.');
		}

		if (!isset($data['keyname'])) {
			throw new ConstructorMetaDataException('The keyname keyname is mandatory in order to convert data to a ConstructorMetaData object.');
		}

		try {

            $isKey = false;
			if (isset($data['is_key'])) {
				$isKey = (bool) $data['is_key'];
			}

            $isUnique = false;
			if (isset($data['is_unique'])) {
				$isUnique = (bool) $data['is_unique'];
			}

			$humanMethodName = null;
			if (isset($data['human_method_name'])) {
				$humanMethodName = $data['human_method_name'];
			}

            $default = null;
			if (isset($data['default'])) {
				$default = $data['default'];
			}

			$transformer = null;
			if (isset($data['transformer'])) {
				$transformer = $this->transformerAdapter->fromDataToTransformer($data['transformer']);
			}

            $type = null;
            if (isset($data['type'])) {
                $type = $this->typeAdapter->fromDataToType($data['type']);
            }

			$argumentMetaData = $this->argumentMetaDataAdapter->fromDataToArgumentMetaData($data['argument_meta_data']);
			return new ConcreteConstructorMetaData($argumentMetaData, $isKey, $isUnique, $data['method_name'], $data['keyname'], $humanMethodName, $transformer, $default, $type);

		} catch (TransformerException $exception) {
			throw new ConstructorMetaDataException('There was an exception while converting data to a Transformer object.', $exception);
		} catch (ArgumentMetaDataException $exception) {
			throw new ConstructorMetaDataException('There was an exception while converting data to an ArgumentMetaData object.', $exception);
		} catch (TypeException $exception) {
            throw new ConstructorMetaDataException('There was an exception while converting data to a Type object.', $exception);
        }

	}

}
