<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteConstructor;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Adapters\ParameterAdapter;

final class ConcreteConstructorAdapter implements ConstructorAdapter {
    private $parameterAdapter;
    private $customMethodAdapter;
    public function __construct(ParameterAdapter $parameterAdapter, CustomMethodAdapter $customMethodAdapter) {
        $this->parameterAdapter = $parameterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
    }

    public function fromInstructionsToConstructor(array $instructions) {
        $parameters = $this->parameterAdapter->fromInstructionsToParameters($instructions);
        $customMethod = $this->customMethodAdapter->fromControllerInstructionsToCustomMethod($instructions);
        return new ConcreteConstructor($customMethod, $parameters);
    }

    public function fromObjectToConstructor(Object $object) {

        $customMethod = null;
        if ($object->hasCombos()) {
            $combos = $object->getCombos();
            $customMethod = $this->customMethodAdapter->fromCombosToCustomMethod($combos);
        }

        $parameters = $this->parameterAdapter->fromObjectToParameters($object);
        return new ConcreteConstructor($customMethod, $parameters);
    }

    public function fromTypeToConstructor(Type $type) {
        $parameter = $this->parameterAdapter->fromTypeToParameter($type);
        $customMethod = $this->customMethodAdapter->fromTypeToCustomMethod($type);
        return new ConcreteConstructor($customMethod, [$parameter]);

    }

    public function fromTypeToAdapterConstructor(Type $type) {
        return new ConcreteConstructor();
    }

    public function fromObjectToAdapterConstructor(Object $object) {
        return new ConcreteConstructor();
    }

}
