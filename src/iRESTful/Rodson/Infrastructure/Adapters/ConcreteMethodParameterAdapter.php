<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethodParameter;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteMethodParameterAdapter implements ParameterAdapter {
    private $returnedInterfaceAdapter;
    public function __construct(ReturnedInterfaceAdapter $returnedInterfaceAdapter) {
        $this->returnedInterfaceAdapter = $returnedInterfaceAdapter;
    }

    public function fromTypeToParameter(Type $type) {

        $convert = function(Type $type) {
            $name = $type->getName();
            return lcfirst($name);
        };

        try {

            $name = $convert($type);
            $interface = $this->returnedInterfaceAdapter->fromTypeToReturnedInterface($type);
            return new ConcreteMethodParameter($name, $interface);

        } catch (ReturnedInterfaceException $exception) {
            throw new ParameterException('There was an exception while converting a Type object to a ReturnedInterface object.', $exception);
        }
    }

}
