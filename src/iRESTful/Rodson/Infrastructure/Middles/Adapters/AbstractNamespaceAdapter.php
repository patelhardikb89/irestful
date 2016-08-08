<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Namespaces\Exceptions\NamespaceException;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;

abstract class AbstractNamespaceAdapter implements NamespaceAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromObjectToNamespace(Object $object) {
        throw new NamespaceException('The fromObjectToNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromTypeToNamespace(Type $type) {
        throw new NamespaceException('The fromTypeToAdapterNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromTypeToAdapterNamespace(Type $type) {
        throw new NamespaceException('The fromTypeToAdapterNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromPropertyTypeToNamespace(PropertyType $propertyType) {

        if ($propertyType->hasType()) {
            $type = $propertyType->getType();
            return $this->fromTypeToNamespace($type);
        }

        if ($propertyType->hasObject()) {
            $object = $propertyType->getObject();
            return $this->fromObjectToNamespace($object);
        }

        throw new NamespaceException('The given propertyType did not have a Type or an Object.  Primitives do not have namespaces.');

    }

    protected function fromDataToNamespace(array $data) {
        $merged = array_merge($this->baseNamespace, $data);
        return new ConcreteNamespace($merged);
    }

    protected function convert($name) {
        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return ucfirst($name);
    }

}
