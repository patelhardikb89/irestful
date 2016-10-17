<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Classes\Domain\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Classes\Infrastructure\Objects\ConcreteConstructor;
use iRESTful\Classes\Domain\Constructors\Parameters\Adapters\ParameterAdapter;

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
        $parameters = $this->parameterAdapter->fromObjectToParameters($object);
        return new ConcreteConstructor(null, $parameters);
    }

    public function fromTypeToConstructor(Type $type) {
        $parameter = $this->parameterAdapter->fromTypeToParameter($type);
        $customMethod = $this->customMethodAdapter->fromTypeToCustomMethod($type);
        return new ConcreteConstructor($customMethod, [$parameter]);

    }

    public function fromTypeToAdapterConstructor(Type $type) {
        return new ConcreteConstructor();
    }

}
