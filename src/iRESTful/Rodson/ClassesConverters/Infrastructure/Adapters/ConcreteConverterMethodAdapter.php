<?php
namespace iRESTful\Rodson\ClassesConverters\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesConverters\Domain\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\ClassesConverters\Infrastructure\Objects\ConcreteConverterMethod;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Type;

final class ConcreteConverterMethodAdapter implements MethodAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromDataToMethods(array $data) {

        if (!isset($data['type'])) {
            throw new CustomMethodException('The type keyname is mandatory in order to convert data to CustomMethod objects.');
        }

        if (!isset($data['namespace'])) {
            throw new CustomMethodException('The namespace keyname is mandatory in order to convert data to CustomMethod objects.');
        }

        $type = $data['type'];
        $namespace = $data['namespace'];
        $parameterAdapter = $this->parameterAdapter;
        $fromConverterToCustomMethod = function(Converter $converter) use(&$type, &$namespace, &$parameterAdapter) {

            $getMethodName = function() use(&$converter, &$type) {

                $rewriteName = function($name) {
                    $matches = [];
                    preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

                    foreach($matches[0] as $oneElement) {
                        $replacement = strtoupper(str_replace('_', '', $oneElement));
                        $name = str_replace($oneElement, $replacement, $name);
                    }

                    return $name;
                };

                $getName = function(Type $type) {

                    if ($type->hasType()) {
                        return $type->getType()->getName();
                    }

                    if ($type->hasPrimitive()) {
                        return $type->getPrimitive()->getName();
                    }

                    //throws

                };

                $from = null;
                $to = null;

                if ($converter->hasFromType()) {
                    $fromType = $converter->fromType();
                    $from = $getName($fromType);
                }

                if ($converter->hasToType()) {
                    $toType = $converter->toType();
                    $to = $getName($toType);
                }

                if (empty($from)) {
                    $from = $type->getName();
                }

                if (empty($to)) {
                    $to = $type->getName();
                }

                return $rewriteName('from_'.$from.'_to_'.$to);

            };

            $getPrimitive = function() use(&$converter, &$type) {
                if ($converter->hasFromType()) {
                    $type = $converter->fromType();
                }

                if ($type->hasPrimitive()) {
                    return $type->getPrimitive();
                }

                return null;
            };

            $getNamespace = function() use(&$converter, &$type) {
                if ($converter->hasFromType()) {
                    $type = $converter->fromType();
                }

                if ($type->hasType()) {
                    $typeType = $type->getType();
                    return $typeType->getNamespace();
                }

                return null;

            };


            $methodName = $getMethodName($converter);
            $primitive =
            $parameter = $parameterAdapter->fromDataToParameter([
                'name' => 'value',
                'primitive' => $getPrimitive(),
                'namespace' => $getNamespace()
            ]);
            
            return new ConcreteConverterMethod($methodName, $parameter, $namespace);

        };

        $databaseConverter = $data['type']->getDatabaseConverter();
        $customMethods = [
            $fromConverterToCustomMethod($databaseConverter)
        ];

        if ($data['type']->hasViewConverter()) {
            $viewConverter = $data['type']->getViewConverter();
            $customMethods[] = $fromConverterToCustomMethod($viewConverter);
        }

        return $customMethods;

    }

}
