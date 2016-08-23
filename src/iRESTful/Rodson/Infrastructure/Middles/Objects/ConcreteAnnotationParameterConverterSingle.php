<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles\SingleConverter;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles\Exceptions\SingleConverterException;

final class ConcreteAnnotationParameterConverterSingle implements SingleConverter {
    private $interfaceName;
    private $methodName;
    public function __construct($interfaceName, $methodName) {

        if (empty($interfaceName) || !is_string($interfaceName)) {
            throw new SingleConverterException('The interfaceName must be a non-empty string.');
        }

        if (empty($methodName) || !is_string($methodName)) {
            throw new SingleConverterException('The methodName must be a non-empty string.');
        }

        $this->interfaceName = $interfaceName;
        $this->methodName = $methodName;

    }

    public function getInterfaceName() {
        return $this->interfaceName;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function getData() {
        return [
            'interface' => $this->getInterfaceName(),
            'method' => $this->getMethodName()
        ];
    }

}
