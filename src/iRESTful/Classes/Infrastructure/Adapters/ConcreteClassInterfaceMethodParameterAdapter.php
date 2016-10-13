<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Exceptions\ParameterException;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Types\Adapters\TypeAdapter;
use iRESTful\Classes\Infrastructure\Objects\ConcreteClassInterfaceMethodParameter;
use iRESTful\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Type;

final class ConcreteClassInterfaceMethodParameterAdapter implements ParameterAdapter {
    private $namespaceAdapter;
    private $typeAdapter;
    public function __construct(InterfaceNamespaceAdapter $namespaceAdapter, TypeAdapter $typeAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->typeAdapter = $typeAdapter;
    }

    public function fromTypeToParameter(Type $type) {

        $getName = function(Type $type) {
            if ($type->hasType()) {
                return $type->getType()->getName();
            }

            return $type->getPrimitive()->getName();
        };

        $name = $getName($type);
        if ($type->hasPrimitive()) {
            return $this->fromDataToParameter([
                'name' => $name
            ]);
        }

        $namespace = $this->namespaceAdapter->fromTypeToNamespace($type);
        return $this->fromDataToParameter([
            'name' => $name,
            'namespace' => $namespace
        ]);
    }

    public function fromDataToParameter(array $data) {

        $convert = function($name) {
            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return lcfirst($name);
        };

        if (!isset($data['name'])) {
            throw new ParameterException('The name keyname is mandatory in order to convert data to a Parameter object.');
        }

        $isOptional = false;
        if (isset($data['is_optional'])) {
            $isOptional = (bool) $data['is_optional'];
        }

        $isArray = false;
        if (isset($data['is_array'])) {
            $isArray = (bool) $data['is_array'];
        }

        $typeData = ['is_array' => $isArray];
        if (isset($data['namespace'])) {
            $typeData['namespace'] = $data['namespace'];
        }

        if (isset($data['primitive'])) {
            $typeData['primitive'] = $data['primitive'];
        }

        $name = $convert($data['name']);
        $type = $this->typeAdapter->fromDataToType($typeData);
        return new ConcreteClassInterfaceMethodParameter($name, $type, $isOptional);

    }

}
