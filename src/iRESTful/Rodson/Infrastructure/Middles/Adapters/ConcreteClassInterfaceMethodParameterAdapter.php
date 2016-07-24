<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInterfaceMethodParameter;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

final class ConcreteClassInterfaceMethodParameterAdapter implements ParameterAdapter {
    private $namespaceAdapter;
    private $typeAdapter;
    public function __construct(NamespaceAdapter $namespaceAdapter, TypeAdapter $typeAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->typeAdapter = $typeAdapter;
    }

    public function fromTypeToParameter(Type $type) {
        $name = $type->getName();
        $namespace = $this->namespaceAdapter->fromTypeToNamespace($type);

        return $this->fromDataToParameter([
            'name' => $name,
            'namespace' => $namespace
        ]);
    }

    public function fromDataToParameter(array $data) {

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

        $type = $this->typeAdapter->fromDataToType($typeData);
        return new ConcreteClassInterfaceMethodParameter($data['name'], $type, $isOptional);

    }

}
