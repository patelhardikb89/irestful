<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteInterface;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

final class ConcreteInterfaceAdapter implements InterfaceAdapter {
    private $namespaceAdapter;
    private $methodAdapter;
    public function __construct(InterfaceNamespaceAdapter $namespaceAdapter, MethodAdapter $methodAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->methodAdapter = $methodAdapter;
    }

    public function fromControllerToInterface(Controller $controller) {

        $method = $this->methodAdapter->fromControllerToMethod($controller);
        $namespace = $this->namespaceAdapter->fromControllerToNamespace($controller);

        return new ConcreteInterface([$method], $namespace, false);
    }

    public function fromObjectToInterface(Object $object) {

        $isEntity = $object->hasDatabase();
        $methods = $this->methodAdapter->fromObjectToMethods($object);
        $namespace = $this->namespaceAdapter->fromObjectToNamespace($object);

        return new ConcreteInterface($methods, $namespace, $isEntity);
    }

    public function fromTypeToInterface(Type $type) {

        $method = $this->methodAdapter->fromTypeToMethod($type);
        $namespace = $this->namespaceAdapter->fromTypeToNamespace($type);

        return new ConcreteInterface([$method], $namespace, false);

    }

    public function fromTypeToAdapterInterface(Type $type) {

        $methods = $this->methodAdapter->fromTypeToAdapterMethods($type);
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);

        return new ConcreteInterface($methods, $namespace, false);
    }

    public function fromObjectToAdapterInterface(Object $object) {
        $methods = $this->methodAdapter->fromObjectToAdapterMethods($object);
        $namespace = $this->namespaceAdapter->fromObjectToAdapterNamespace($object);
        
        return new ConcreteInterface($methods, $namespace, false);
    }

}
