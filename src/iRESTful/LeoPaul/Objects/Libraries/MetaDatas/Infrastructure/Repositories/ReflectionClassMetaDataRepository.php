<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Adapters\ClassMetaDataAdapter;

final class ReflectionClassMetaDataRepository implements ClassMetaDataRepository {
	private $classMetaDataAdapter;
	private $containerClassMapper;
	private $interfaceClassMapper;
	private $cache;
	public function __construct(ClassMetaDataAdapter $classMetaDataAdapter, array $containerClassMapper, array $interfaceClassMapper) {
		$this->classMetaDataAdapter = $classMetaDataAdapter;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->cache = [];
	}

	public function retrieve(array $criteria) {

		if (isset($criteria['container'])) {
			if (!isset($this->containerClassMapper[$criteria['container']])) {
				throw new ClassMetaDataException('The given container name ('.$criteria['container'].') does not have a matching class name.');
			}

			$className = $this->containerClassMapper[$criteria['container']];
			return $this->retrieveByClassName($className);
		}

		if (isset($criteria['class'])) {
			return $this->retrieveByClassName($criteria['class']);
		}

		if (isset($criteria['object'])) {

            if (!is_object($criteria['object'])) {
                throw new ClassMetaDataException('The given object is not an object.');
            }

			$className = get_class($criteria['object']);
			return $this->retrieveByClassName($className);
		}

		throw new ClassMetaDataException('There was no valid retriever criteria.');

	}

	private function retrieveByClassName($className) {

		if (isset($this->cache[$className])) {
			return $this->cache[$className];
		}

		if (isset($this->interfaceClassMapper[$className])) {
			$className = $this->interfaceClassMapper[$className];
		}

		$class = new \ReflectionClass($className);
		$arguments = $this->retrieveArguments($class);
		$containerName = $this->retrieveContainerName($class);

		$data = [
			'class' => $className,
			'arguments' => $arguments
		];

		if (!empty($containerName)) {
			$data['container_name'] = $containerName;
		}

		$this->cache[$className] = $this->classMetaDataAdapter->fromDataToClassMetaData($data);
		return $this->cache[$className];
	}

	private function retrieveContainerName(\ReflectionClass $class) {
        $matches = [];
        $comment = $class->getDocComment();
        preg_match_all('/@container -> ([a-z\_]+)/s', $comment, $matches);

        if (!isset($matches[1][0]) || empty($matches[1][0])) {
			return null;
        }

        return $matches[1][0];
    }

	private function retrieveArguments(\ReflectionClass $class) {

		$className = $class->getName();

		$parentMetaData = [];
        $parentClass = $class->getParentClass();
        if ($parentClass != false) {
            $parentMetaData = $this->retrieveArguments($parentClass);
        }

        $matches = [];
		$constructor = $class->getConstructor();
		if (empty($constructor)) {
            throw new ClassMetaDataException('The given class ('.$className.') does not have a constructor.');
		}

        $comment = $constructor->getDocComment();
        $association = '@([a-zA-Z\_]+) -> ([a-zA-Z\_\(\)\-\>]+)( \|\| ([a-zA-Z\_\(\)\-\>]+))? -> ([a-zA-Z\_]+)';
        $key = '( \+\+( @key)?( @unique)?( @default -> \'([^\']+)\')?)?';
        $type = '( \#\#( @(boolean))?( @(binary)( (specific) -> ([0-9]+))?( (max) -> ([0-9]+))?)?( @(string)( (specific) -> ([0-9]+))?( (max) -> ([0-9]+))?)?( @(integer) (max) -> ([0-9]+))?( @(float)( (digits) -> ([0-9]+))?( (precision) -> ([0-9]+))?)?)?';
        $transform = '( \*\* ([a-zA-Z\_\\\]+)::([a-zA-Z\_]+))?( \|\| ([a-zA-Z\_\\\]+)::([a-zA-Z\_]+))?';
        $entityType = '( \*\* \@([a-zA-Z\-]+) -> ([a-zA-Z\_\\\]+))?';
        preg_match_all('/'.$association.$key.$type.$transform.$entityType.'/s', $comment, $matches);

        if (!is_array($matches[0]) || empty($matches[0])) {
            throw new ClassMetaDataException('The given class ('.$className.') does not have valid constructor annotations.');
        }

        $output = [];
        $amount = count($matches[0]);
        for($i = 0; $i < $amount; $i++) {

			$elementsType = null;
			if (!empty($matches[50][$i]) && !empty($matches[49][$i])) {
				if ($matches[49][$i] == 'elements-type') {
					$elementsType = $matches[50][$i];
				}
            }

            $arrayTransformers = null;
            if (!empty($matches[43][$i]) && !empty($matches[44][$i]) && !empty($matches[46][$i]) && !empty($matches[47][$i])) {

                $arrayTransformers = [
                    'to_data_transformer' => [
                        'type' => $matches[43][$i],
                        'method_name' => $matches[44][$i]
                    ],
                    'to_object_transformer' => [
                        'type' => $matches[46][$i],
                        'method_name' => $matches[47][$i]
                    ]
                ];

            }

			$argumentName = $matches[1][$i];
			$argumentMetaData = $this->retrieveArgumentMetaData($className, $constructor, $argumentName, $elementsType, $arrayTransformers);
			if (empty($argumentMetaData)) {
				throw new ClassMetaDataException('The argument ('.$argumentName.') cannot be found inside the '.$className."'s constructor.");
			}

			$data = [
				'argument_meta_data' => $argumentMetaData,
				'method_name' => $matches[2][$i],
				'keyname' => $matches[5][$i]
			];

            $type = $this->getTypeFromMatches($matches, $i);
            if (!empty($type)) {
                $data['type'] = $type;
            }

			if (isset($matches[4][$i]) && !empty($matches[4][$i])) {
				$data['human_method_name'] = $matches[4][$i];
			}

            if (!empty($matches[43][$i]) && !empty($matches[44][$i]) && empty($arrayTransformers)) {
                $data['transformer'] = [
                    'type' => $matches[43][$i],
                    'method_name' => $matches[44][$i]
                ];
            }

            $data['is_key'] = false;
            if (!empty($matches[7][$i]) && ($matches[7][$i] == ' @key')) {
                $data['is_key'] = true;
            }

            $data['is_unique'] = false;
            if (!empty($matches[8][$i]) && ($matches[8][$i] == ' @unique')) {
                $data['is_unique'] = true;
            }

            $data['default'] = null;
            if (!empty($matches[10][$i])) {
                $data['default'] = trim($matches[10][$i]);
            }

			$output[$argumentName] = $data;

        }

        return array_merge($parentMetaData, $output);
	}

	private function retrieveArgumentMetaData($className, \ReflectionMethod $constructor, $argumentName, $elementsType = null, $transformers = null) {

		$parameters = $constructor->getParameters();
		foreach($parameters as $oneParameter) {

			$name = $oneParameter->getName();
			if ($name == $argumentName) {

				$position = $oneParameter->getPosition();
				$isOptional = $oneParameter->isOptional();

				$data = [
					'name' => $name,
					'position' => $position,
					'is_optional' => $isOptional,
					'is_recursive' => false
				];

				if ($oneParameter->isArray()) {
					$data['array_meta_data'] = [];
					if (!empty($elementsType)) {
						$data['array_meta_data'] = [
							'elements_type' => $elementsType
						];
					}

                    if (!empty($transformers)) {
                        $data['array_meta_data'] = [
							'transformers' => $transformers
						];
                    }

				}

				$parameterClass = $oneParameter->getClass();
				if (!empty($parameterClass)) {
					$parameterClassName = $parameterClass->getName();
					if (($parameterClassName != $className)) {

						try {
							$data['class_meta_data'] = $this->retrieveByClassName($parameterClassName);
						} catch (ClassMetaDataException $exception) {

						}
					}

					if ($parameterClassName == $className) {
						$data['is_recursive'] = true;
					}
				}

				return $data;
			}

		}

		return null;

	}

    private function getTypeFromMatches(array $matches, $i) {
        
        if (!empty($matches[13][$i]) && ($matches[13][$i] == 'boolean')) {

            $type = [
                'name' => 'boolean'
            ];

            return $type;
        }

        if (!empty($matches[15][$i]) && ($matches[15][$i] == 'binary')) {

            $type = [
                'name' => 'binary'
            ];

            if (!empty($matches[18][$i])) {
                $type['specific_bit_size'] = $matches[18][$i];
            }

            if (!empty($matches[20][$i])) {
                $type['max_bit_size'] = $matches[20][$i];
            }

            return $type;
        }

        if (!empty($matches[31][$i]) && ($matches[31][$i] == 'integer') && !empty($matches[33][$i])) {
            return [
                'name' => 'integer',
                'max_bit_size' => $matches[33][$i]
            ];
        }

        if (!empty($matches[23][$i]) && ($matches[23][$i] == 'string')) {

            $type = [
                'name' => 'string'
            ];

            if (!empty($matches[26][$i])) {
                $type['specific_character_size'] = $matches[26][$i];
            }

            if (!empty($matches[29][$i])) {
                $type['max_character_size'] = $matches[29][$i];
            }

            return $type;
        }

        if (!empty($matches[34][$i]) && ($matches[35][$i] == 'float')) {

            $type = [
                'name' => 'float'
            ];

            if (!empty($matches[38][$i])) {
                $type['digits_amount'] = $matches[38][$i];
            }

            if (!empty($matches[41][$i])) {
                $type['precision'] = $matches[41][$i];
            }

            return $type;
        }

        return null;
    }

}
