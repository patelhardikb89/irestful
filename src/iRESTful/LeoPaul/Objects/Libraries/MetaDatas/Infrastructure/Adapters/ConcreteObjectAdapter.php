<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Wrappers\Adapters\ClassMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\Adapters\ObjectMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteObjectAdapter implements ObjectAdapter {
    private $transformerWrapperAdapter;
	private $objectMetaDataAdapter;
	private $classMetaDataWrapperAdapter;
	private $classMetaDataRepository;
	private $containerClassMapper;
	private $interfaceClassMapper;
	private $delimiter;
	public function __construct(
        TransformerWrapperAdapter $transformerWrapperAdapter,
		ObjectMetaDataAdapter $objectMetaDataAdapter,
		ClassMetaDataWrapperAdapter $classMetaDataWrapperAdapter,
		ClassMetaDataRepository $classMetaDataRepository,
		array $containerClassMapper,
		array $interfaceClassMapper,
		$delimiter
	) {
        $this->transformerWrapperAdapter = $transformerWrapperAdapter;
		$this->objectMetaDataAdapter = $objectMetaDataAdapter;
		$this->classMetaDataWrapperAdapter = $classMetaDataWrapperAdapter;
		$this->classMetaDataRepository = $classMetaDataRepository;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->delimiter = $delimiter;
	}

	public function fromObjectToData($object, $isHumanReadable) {

		$delimiter = $this->delimiter;
		$classMetaDataRepository = $this->classMetaDataRepository;
        $transformerWrapperAdapter = $this->transformerWrapperAdapter;
		$isHumanReadable = (bool) $isHumanReadable;
		$adapter = $this;
		$merge = function(ArgumentMetaData $argumentMetaData, $currentValue, $currentKeyname, array &$output) use($adapter, $classMetaDataRepository, $transformerWrapperAdapter, $delimiter, $isHumanReadable) {

			$normalize = function(array $data, $keyname, $delimiter) {
				$output = [];
				foreach($data as $oneKeyname => $oneValue) {
					$output[$keyname.$delimiter.$oneKeyname] = $oneValue;
				}

				return $output;
			};

			$transform = function(ArgumentMetaData $argumentMetaData, $value) use($adapter, $transformerWrapperAdapter, $isHumanReadable) {

				if ($argumentMetaData->hasArrayMetaData() && is_array($value)) {

                    $arrayMetaData = $argumentMetaData->getArrayMetaData();
                    if ($arrayMetaData->hasTransformers()) {
                        $toObjectTransformer = $arrayMetaData->getToDataTransformer();
                        $transformerWrapper = $transformerWrapperAdapter->fromTransformerToTransformerWrapper($toObjectTransformer);
        				return $transformerWrapper->transform($value);
                    }

					return $adapter->fromObjectsToData($value, $isHumanReadable);
	            }

				if (is_object($value)) {
					return $adapter->fromObjectToData($value, $isHumanReadable);
				}

				return $value;

			};

			$transformed = $transform($argumentMetaData, $currentValue);
			if (is_object($currentValue)) {
				$argumentClassMetaData = $classMetaDataRepository->retrieve([
					'object' => $currentValue
				]);

				if (!$argumentClassMetaData->hasContainerName()) {
					$normalized = $normalize($transformed, $currentKeyname, $delimiter);
					$output = array_merge($output, $normalized);
					return;
				}
			}

			$output[$currentKeyname] = $transformed;

		};

		try {

			$classMetaData = $this->classMetaDataRepository->retrieve([
				'object' => $object
			]);

			$output = [];
			$arguments = $classMetaData->getArguments();
			$objectMetaData = $this->objectMetaDataAdapter->fromObjectToObjectMetaData($object);
			foreach($arguments as $constructorMetaData) {

				$argumentMetaData = $constructorMetaData->getArgumentMetaData();
				$keyname = $constructorMetaData->getKeyname();
				$methodName = $constructorMetaData->getMethodName();
				if ($isHumanReadable && $constructorMetaData->hasHumanMethodName()) {
					$methodName = $constructorMetaData->getHumanMethodName();
				}

				$value = $objectMetaData->call($methodName);
				$merge($argumentMetaData, $value, $keyname, $output);

			}

			return $output;

		} catch (ClassMetaDataException $exception) {
			throw new ObjectException('There was an exception while retrieving a ClassMetaData object from its repository.', $exception);
		} catch (TransformerException $exception) {
            throw new ObjectException('There was an exception while transforming data.', $exception);
        }
	}

	public function fromObjectsToData(array $objects, $isHumanReadable) {
		$output = [];
		foreach($objects as $keyname => $oneObject) {
			$output[$keyname] = $this->fromObjectToData($oneObject, $isHumanReadable);
		}

		return $output;
	}

	public function fromDataToObject(array $data) {

		$getClassName = function(array $data) {

			if (isset($data['class']) && isset($data['container'])) {
				throw new ObjectException('There must be either a class or a container, or none.  Not both.');
			}

			$className = null;
			if (isset($data['class'])) {
				$className = $data['class'];
			}

			if (isset($data['container'])) {
				$containerName = $data['container'];
				if (!isset($this->containerClassMapper[$containerName])) {
					throw new ObjectException('The given container ('.$containerName.') does not have a matching class in the containerClassMapper.');
				}

				$className = $this->containerClassMapper[$containerName];

			}

			if (!empty($className) && isset($this->interfaceClassMapper[$className])) {
				$className = $this->interfaceClassMapper[$className];
			}

			if (empty($className)) {
				throw new ObjectException('The class or container is mandatory in the data in order to convert it to an object.');
			}

			return $className;

		};

		if (!isset($data['data'])) {
			throw new ObjectException('The data keyname is mandatory in order to convert it to an object.');
		}

		try {

			$classMetaData = $this->classMetaDataRepository->retrieve([
				'class' => $getClassName($data)
			]);

			$callbackOnFail = isset($data['callback_on_fail']) ? $data['callback_on_fail'] : null;
			$classMetaDataWrapper = $this->classMetaDataWrapperAdapter->fromDataToClassMetaDataWrapper([
				'object_adapter' => $this,
				'class_meta_data' => $classMetaData,
				'class' => $classMetaData->getType(),
				'callback_on_fail' => $callbackOnFail
			]);

			return $classMetaDataWrapper->transform($data['data']);

		} catch (ClassMetaDataException $exception) {
			throw new ObjectException('There was an exception while retrieving a ClassMetaData object from its repository, or when transforming data to a ClassMetaDataWrapper or when transforming a data input to an output object.', $exception);
		}
	}

	public function fromDataToObjects(array $data) {
		$output = [];
		foreach($data as $keyname => $oneData) {
			$output[$keyname] = $this->fromDataToObject($oneData);
		}

		return $output;
	}

    private function fromObjectToSubObjectsInternally($object) {

        try {

            $classMetaData = $this->classMetaDataRepository->retrieve([
                'object' => $object
            ]);

            $subObjects = [];
            $arguments = $classMetaData->getArguments();
            $objectMetaData = $this->objectMetaDataAdapter->fromObjectToObjectMetaData($object);
            foreach($arguments as $oneConstructorMetaData) {
                $methodName = $oneConstructorMetaData->getMethodName();
                $value = $objectMetaData->call($methodName);

                if (is_object($value)) {

                    $subSubObjects = $this->fromObjectToSubObjectsInternally($value);

                    $subObjects[] = [
                        'amount' => count($subSubObjects),
                        'object' => $value
                    ];

                    $subObjects = array_merge($subObjects, $subSubObjects);
                    continue;
                }

                if (is_array($value)) {

                    foreach($value as $oneValue) {

                        $valueSubObjects = $this->fromObjectToSubObjectsInternally($oneValue);

                        $subObjects[] = [
                            'amount' => count($valueSubObjects),
                            'object' => $oneValue
                        ];

                        $subObjects = array_merge($subObjects, $valueSubObjects);
                    }

                    continue;
                }
            }

            return $subObjects;

        } catch (ClassMetaDataException $exception) {
            throw new ObjectException('There was an exception while retrieving a ClassMetaData object.', $exception);
        }

    }

    public function fromObjectToSubObjects($object) {
        $subObjects = $this->fromObjectToSubObjectsInternally($object);
        return $this->reorderInternalSubObjects($subObjects);
    }

    private function reorderInternalSubObjects(array $subObjects, $currentAmount = 0) {
        $output = [];
        $remainingSubObjects = [];
        foreach($subObjects as $oneSubObject) {

            if ($oneSubObject['amount'] == $currentAmount) {
                $output[] = $oneSubObject['object'];
                continue;
            }

            $remainingSubObjects[] = $oneSubObject;

        }

        if (empty($remainingSubObjects)) {
            return $output;
        }

        $currentAmount++;
        $nextSubObjects = $this->reorderInternalSubObjects($remainingSubObjects, $currentAmount);
        return array_merge($output, $nextSubObjects);
    }

    private function fromObjectsToSubObjectsInternally(array $objects) {

        $subObjects = [];
        foreach($objects as $oneObject) {

            if (!is_object($oneObject)) {
                continue;
            }

            $objectSubObjects = $this->fromObjectToSubObjectsInternally($oneObject);
            $subObjects = array_merge($subObjects, $objectSubObjects);
        }

        return $subObjects;

    }

    public function fromObjectsToSubObjects(array $objects) {
        $subObjects = $this->fromObjectsToSubObjectsInternally($objects);
        return $this->reorderInternalSubObjects($subObjects);
    }

    public function fromObjectToRelationObjects($object) {

        try {

            $classMetaData = $this->classMetaDataRepository->retrieve([
                'object' => $object
            ]);

            $relationObjects = [];
            $arguments = $classMetaData->getArguments();
            $objectMetaData = $this->objectMetaDataAdapter->fromObjectToObjectMetaData($object);
            foreach($arguments as $oneConstructorMetaData) {
                $methodName = $oneConstructorMetaData->getMethodName();
                $value = $objectMetaData->call($methodName);

                if (!is_array($value) || empty($value)) {
                    continue;
                }

                $keyname = $oneConstructorMetaData->getKeyname();
                $relationObjects[$keyname] = $value;
            }

            return $relationObjects;

        } catch (ClassMetaDataException $exception) {
            throw new ObjectException('There was an exception while retrieving a ClassMetaData object.', $exception);
        }
    }

    public function fromObjectToEmptyRelationObjectKeynames($object) {

        try {

            $classMetaData = $this->classMetaDataRepository->retrieve([
                'object' => $object
            ]);

            $containers = [];
            $arguments = $classMetaData->getArguments();
            $objectMetaData = $this->objectMetaDataAdapter->fromObjectToObjectMetaData($object);
            foreach($arguments as $oneConstructorMetaData) {
                $methodName = $oneConstructorMetaData->getMethodName();
                $value = $objectMetaData->call($methodName);

                if (is_array($value) || !empty($value)) {
                    continue;
                }

                $argumentMetaData = $oneConstructorMetaData->getArgumentMetaData();
                if (!$argumentMetaData->hasArrayMetaData()) {
                    continue;
                }

                $arrayMetaData = $argumentMetaData->getArrayMetaData();
                if (!$arrayMetaData->hasElementsType()) {
                    continue;
                }

                $elementsType = $arrayMetaData->getElementsType();
                $containers[] = $oneConstructorMetaData->getKeyname();
            }

            return $containers;

        } catch (ClassMetaDataException $exception) {
            throw new ObjectException('There was an exception while retrieving a ClassMetaData object.', $exception);
        }
    }

    public function fromObjectsToRelationObjectsList(array $objects) {

        $output = [];
        foreach($objects as $oneObject) {
            $output[] = $this->fromObjectToRelationObjects($oneObject);
        }

        return $output;

    }

}
