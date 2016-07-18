<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteNamespaceAdapter implements NamespaceAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromStringToNamespace($string) {

        $pos = strpos($string, '\\');
        if ($pos === 0) {
            return new ConcreteNamespace([$string], false);
        }

        $exploded = explode('\\', $string);
        return new ConcreteNamespace($exploded, true);

    }

    public function fromDataToNamespace(array $data) {
        $namespace = array_merge($this->baseNamespace, $data);
        return new ConcreteNamespace($namespace, true);
    }

}
