<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassConstructor;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Adapters\ParameterAdapter;

final class ConcreteClassConstructorAdapter implements ConstructorAdapter {
    private $parameterAdapter;
    private $customMethodAdapter;
    public function __construct(ParameterAdapter $parameterAdapter, CustomMethodAdapter $customMethodAdapter) {
        $this->parameterAdapter = $parameterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
    }

    public function fromInstructionsToConstructor(array $instructions) {
        $parameters = $this->parameterAdapter->fromInstructionsToParameters($instructions);
        $customMethod = $this->customMethodAdapter->fromControllerInstructionsToCustomMethod($instructions);
        return new ConcreteClassConstructor($customMethod, $parameters);
    }

    public function fromObjectToConstructor(Object $object) {
        $parameters = $this->parameterAdapter->fromObjectToParameters($object);
        return new ConcreteClassConstructor(null, $parameters);
    }

    public function fromTypeToConstructor(Type $type) {
        $parameter = $this->parameterAdapter->fromTypeToParameter($type);
        $customMethod = $this->customMethodAdapter->fromTypeToCustomMethod($type);
        return new ConcreteClassConstructor($customMethod, [$parameter]);

    }

    public function fromTypeToAdapterConstructor(Type $type) {
        return new ConcreteClassConstructor();
    }

}
