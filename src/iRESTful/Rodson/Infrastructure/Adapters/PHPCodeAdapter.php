<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;
use iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Classes\ObjectClass;

final class PHPCodeAdapter implements CodeAdapter {
    private $baseFilePath;
    public function __construct($baseFilePath) {
        $this->baseFilePath = $baseFilePath;
    }

    public function fromInterfaceToCode(Interface $interface) {

        $name = $interface->getName();
        $methods = $interface->getMethods();

        $methodsCode = [];
        $includedNamespaces = [];
        foreach($methods as $oneMethod) {

            $methodName = $oneMethod->getName();
            if (!$oneMethod->hasParameters()) {
                $methodsCode[] = 'public function '.$methodName.'();';
                continue;
            }

            $parametersCode = [];
            $parameters = $oneMethod->getParameters();
            foreach($parameters as $oneParameter) {

                $name = $oneParameter->getName();
                if (!$oneParameter->hasReturnedInterface()) {
                    $parametersCode[] = $name;
                    continue;
                }

                $returnedInterface = $oneParameter->getReturnedInterface();
                $interfaceName = $returnedInterface->getName();
                $parametersCode[] = $interfaceName.' '.$name;
                $includedNamespaces[] = $returnedInterface->getNamespace()->get();
                continue;
            }

            $methodsCode[] = 'public function '.$methodName.'('.implode(', ', $parametersCode).');';
            continue;
        }

        $currentNamespace = $interface->getNamespace()->get();
        $code = '<?php
namespace '.$currentNamespace.';
'.implode(PHP_EOL, $includedNamespaces).'

interface '.$name.' {
'.implode(PHP_EOL, $methodsCode).'
}';

        $relativeFilePath = '/'.str_replace('\\', '/', $currentNamespace).'/'.$name.'.php';
        return new ConcreteOutputCode($code, $relativeFilePath);
    }

    public function fromClassToCode(ObjectClass $class) {
        
    }

}
