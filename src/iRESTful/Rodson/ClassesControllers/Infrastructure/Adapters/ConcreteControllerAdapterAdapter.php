<?php
namespace iRESTful\Rodson\ClassesControllers\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesControllers\Domain\Adapters\Adapters\ControllerAdapterAdapter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Rodson\ClassesControllers\Infrastructure\Adapters\ConcreteControllerAdapter;
use iRESTful\Rodson\ClassesControllers\Domain\Exceptions\ControllerException;

final class ConcreteControllerAdapterAdapter implements ControllerAdapterAdapter {
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    public function __construct(
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        ClassNamespaceAdapter $namespaceAdapter
    ) {
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
    }

    public function fromDataToControllerAdapter(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new ControllerException('The annotated_entities keyname is mandatory in order to convert data to a ControllerAdapter object.');
        }

        if (!isset($data['converters'])) {
            throw new ControllerException('The converters keyname is mandatory in order to convert data to a ControllerAdapter object.');
        }

        return new ConcreteControllerAdapter(
            $this->customMethodAdapter,
            $this->constructorAdapter,
            $this->namespaceAdapter,
            $data['annotated_entities'],
            $data['converters']
        );
    }

}
