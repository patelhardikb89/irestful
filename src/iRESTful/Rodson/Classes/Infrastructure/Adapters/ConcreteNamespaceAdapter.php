<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteNamespaceAdapter implements NamespaceAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromFullDataToNamespace(array $data) {
        return new ConcreteNamespace($data);
    }

    public function fromDataToNamespace(array $data) {

        $converted = [];
        foreach($data as $index => $oneData) {
            $converted[] = $this->convert($oneData);
        }

        $merged = array_merge($this->baseNamespace, $converted);
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
