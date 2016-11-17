<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\Adapters\ArrayMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ConcreteArgumentMetaDataWrapper implements ArgumentMetaDataWrapper {
	private $objectAdapter;
	private $arrayMetaDataWrapperAdapter;
	private $argumentMetaData;
	private $className;
	private $callbackOnFail;
	public function __construct(
        ObjectAdapter $objectAdapter,
        ArrayMetaDataWrapperAdapter $arrayMetaDataWrapperAdapter,
        ArgumentMetaData $argumentMetaData,
        $className,
        \Closure $callbackOnFail = null
    ) {
		$this->objectAdapter = $objectAdapter;
		$this->arrayMetaDataWrapperAdapter = $arrayMetaDataWrapperAdapter;
		$this->argumentMetaData = $argumentMetaData;
		$this->className = $className;
		$this->callbackOnFail = $callbackOnFail;
	}

	public function transform($input = null) {

		try {

            $hasClassMetaData = $this->argumentMetaData->hasClassMetaData();
            $isOptional = $this->argumentMetaData->isOptional();
            $isRecursive = $this->argumentMetaData->isRecursive();
            if (($hasClassMetaData || $isRecursive) && $isOptional && empty($input)) {
                return null;
            }

            if ($isOptional && is_null($input)) {
                return null;
            }

			if ($isRecursive) {
				return $this->objectAdapter->fromDataToObject([
					'class' => $this->className,
					'callback_on_fail' => $this->callbackOnFail,
					'data' => $input
				]);
			}

			$hasArrayMetaData = $this->argumentMetaData->hasArrayMetaData();
            if ($hasArrayMetaData /*&& is_array($input)*/ && !empty($input)) {
				$arrayMetaData = $this->argumentMetaData->getArrayMetaData();
				$arrayMetaDataWrapper = $this->arrayMetaDataWrapperAdapter->fromDataToArrayMetaDataWrapper([
					'array_meta_data' => $arrayMetaData,
					'object_adapter' => $this->objectAdapter,
					'callback_on_fail' => $this->callbackOnFail
				]);

				return $arrayMetaDataWrapper->transform($input);
			}

            if ($hasArrayMetaData && empty($input)) {
                return [];
			}

			if (is_array($input)) {
				$className = $this->className;
				if ($hasClassMetaData) {
					$className = $this->argumentMetaData->getClassMetaData()->getType();
				}

				return $this->objectAdapter->fromDataToObject([
					'class' => $className,
					'data' => $input,
					'callback_on_fail' => $this->callbackOnFail
				]);
			}

            if (!empty($this->callbackOnFail) && $hasClassMetaData) {
                $callBack = $this->callbackOnFail;
                $className = $this->argumentMetaData->getClassMetaData()->getType();
                return $callBack([
                    'class' => $className,
                    'input' => $input
                ]);
            }

			return $input;

		} catch (ObjectException $exception) {
			throw new ArgumentMetaDataException('There was an exception while converting data to an object.', $exception);
		} catch (ArrayMetaDataException $exception) {
			throw new ArgumentMetaDataException('There was an exception while converting data to an ArrayMetaDataWrapper object, or when transforming an array input to an output.', $exception);
		}

	}

}
