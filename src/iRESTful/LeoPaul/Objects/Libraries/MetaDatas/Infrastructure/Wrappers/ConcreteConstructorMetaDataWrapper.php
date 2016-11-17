<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\ConstructorMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\Adapters\ArgumentMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteConstructorMetaDataWrapper implements ConstructorMetaDataWrapper {
	private $objectAdapter;
	private $argumentMetaDataWrapperAdapter;
	private $transformerWrapperAdapter;
	private $constructorMetaData;
	private $className;
	private $delimiter;
	private $callBackOnFail;
	public function __construct(
		ObjectAdapter $objectAdapter,
		ArgumentMetaDataWrapperAdapter $argumentMetaDataWrapperAdapter,
		TransformerWrapperAdapter $transformerWrapperAdapter,
		ConstructorMetaData $constructorMetaData,
		$className,
		$delimiter,
		\Closure $callBackOnFail = null
	) {
		$this->objectAdapter = $objectAdapter;
		$this->argumentMetaDataWrapperAdapter = $argumentMetaDataWrapperAdapter;
		$this->transformerWrapperAdapter = $transformerWrapperAdapter;
		$this->constructorMetaData = $constructorMetaData;
		$this->className = $className;
		$this->delimiter = $delimiter;
		$this->callBackOnFail = $callBackOnFail;
	}

	public function transform(array $data) {

		$argumentMetaData = $this->constructorMetaData->getArgumentMetaData();
		$keyname = $this->constructorMetaData->getKeyname();

		try {

			if (array_key_exists($keyname, $data) && $this->constructorMetaData->hasTransformer()) {
				$transformer = $this->constructorMetaData->getTransformer();
				$transformerWrapper = $this->transformerWrapperAdapter->fromTransformerToTransformerWrapper($transformer);
				return $transformerWrapper->transform($data[$keyname]);
			}

			$argumentMetaDataWrapperParams = [
				'argument_meta_data' => $argumentMetaData,
				'object_adapter' => $this->objectAdapter,
				'class' => $this->className,
				'callback_on_fail' => $this->callBackOnFail
			];

			if (!array_key_exists($keyname, $data)) {
				$subData = [];
				foreach($data as $oneKeyname => $oneValue) {

					$prefix = $keyname.$this->delimiter;
					$pos = strpos($oneKeyname, $prefix);
					if ($pos === 0) {
						$subKeyname = str_replace($prefix, '', $oneKeyname);
						$subData[$subKeyname] = $oneValue;
					}

				}

				if (empty($subData)) {
					return null;
				}

				$hasClassMetaData = $argumentMetaData->hasClassMetaData();
				if (!$hasClassMetaData) {
					$isRecursive = $argumentMetaData->isRecursive();
					if (!$isRecursive) {
						throw new ConstructorMetaDataException('The argument must contain a ClassMetaData to be recursive.');
					}
				}

				$data[$keyname] = $subData;
			}

			$argumentMetaDataWrapper = $this->argumentMetaDataWrapperAdapter->fromDataToArgumentMetaDataWrapper($argumentMetaDataWrapperParams);
			return $argumentMetaDataWrapper->transform($data[$keyname]);

		} catch (ArgumentMetaDataException $exception) {
			throw new ConstructorMetaDataException('There was an exception while transforming data to an ArgumentMetaDataWrapper, or when transforming an input to an output element.', $exception);
		} catch (TransformerException $exception) {
			throw new ConstructorMetaDataException('There was an exception while converting a Transformer object to a TransformerWrapper object, or when transforming an input to an output element.', $exception);
		}
	}

}
