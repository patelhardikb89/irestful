<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\Adapters\ConstructorMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Wrappers\ClassMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConcreteClassMetaDataWrapper implements ClassMetaDataWrapper {
	private $objectAdapter;
	private $classMetaData;
	private $constructorMetaDataWrapperAdapter;
	private $className;
	private $callbackOnFail;
	public function __construct(ObjectAdapter $objectAdapter, ConstructorMetaDataWrapperAdapter $constructorMetaDataWrapperAdapter, ClassMetaData $classMetaData, $className, \Closure $callbackOnFail = null) {
		$this->objectAdapter = $objectAdapter;
		$this->classMetaData = $classMetaData;
		$this->constructorMetaDataWrapperAdapter = $constructorMetaDataWrapperAdapter;
		$this->className = $className;
		$this->callbackOnFail = $callbackOnFail;
	}

	public function transform($input) {

		$currentObject = $this;
        $callbackOnFail = $this->callbackOnFail;
		$callCallback = function(array $data) use (&$currentObject, &$callbackOnFail) {

			$callIt = function() use($data, &$currentObject, &$callbackOnFail) {
				$output = $callbackOnFail($data);
                if (is_array($output)) {

                    if (empty($output)) {
                        return [];
                    }

                    $keys = array_keys($output);
                    if (!is_numeric($keys[0])) {
                        return $currentObject->transform($output);
                    }
                }

				return $output;
			};

			if (empty($callbackOnFail)) {
				throw new ClassMetaDataException('The given input was not an array and there was no callbackOnFail \Closure provided.');
			}

			return $callIt();
		};

		if (!is_array($input)) {

            try {

    			return $callCallback([
                    'class' => $this->className,
                    'input' => $input
                ]);

            } catch (\Exception $exception) {
                throw new ClassMetaDataException('There was an exception while calling the callback with class:('.$this->className.' ... and input: '.$input, $exception);
            }
		}

		try {

            $output = [];
			$constructorMetaDatas = $this->classMetaData->getArguments();
			foreach($constructorMetaDatas as $oneConstructorMetaData) {

				$constructorMetaDataWrapper = $this->constructorMetaDataWrapperAdapter->fromDataToConstructorMetaDataWrapper([
					'object_adapter' => $this->objectAdapter,
					'constructor_meta_data' => $oneConstructorMetaData,
					'class' => $this->className,
					'callback_on_fail' => $callbackOnFail
				]);

				$argumentMetaData = $oneConstructorMetaData->getArgumentMetaData();
				$position = $argumentMetaData->getPosition();

                if (
                    !empty($this->callbackOnFail) &&
                    $argumentMetaData->hasArrayMetaData() &&
                    $argumentMetaData->getArrayMetaData()->hasElementsType() &&
                    isset($input['uuid'])
                ) {

                    $keyname = $oneConstructorMetaData->getKeyname();
                    if (!isset($input[$keyname]) || empty($input[$keyname])) {
                        $output[$position] = $callCallback([
                            'master_container' => $this->classMetaData->getContainerName(),
                            'slave_type' => $argumentMetaData->getArrayMetaData()->getElementsType(),
                            'slave_property' => $keyname,
                            'master_uuid' => $input['uuid']
                        ]);

                        continue;
                    }
                }

                $output[$position] = $constructorMetaDataWrapper->transform($input);
			}

            ksort($output);
			$reflectionClass = new \ReflectionClass($this->className);
			return $reflectionClass->newInstanceArgs($output);

		} catch (ConstructorMetaDataException $exception) {
			throw new ClassMetaDataException('There was an exception while converting data to a ConstructorMetaDataWrapper or transforming the input data to an output.', $exception);
		} catch (\Exception $exception) {

            try {

                return $callCallback([
                    'class' => $this->className,
                    'input' => $input
                ]);

            } catch (\Exception $exception) {
                throw new ClassMetaDataException('There was an exception while calling the callback with class: ('.$this->className.')', $exception);
            }
		}
	}

}
