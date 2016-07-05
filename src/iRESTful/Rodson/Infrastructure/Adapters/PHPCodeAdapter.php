<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Namespaces\Adapters\Adapters\NamespaceAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Objects;

final class PHPCodeAdapter implements CodeAdapter {
    private $namespaceAdapterAdapter;
    private $baseFilePath;
    public function __construct(NamespaceAdapterAdapter $namespaceAdapterAdapter, $baseFilePath) {
        $this->namespaceAdapterAdapter = $namespaceAdapterAdapter;
        $this->baseFilePath = $baseFilePath;
    }

    public function fromInterfaceToCode(Interface $interface) {

        $name = $interface->getName();
        $methods = $interface->getMethods();
        $namespaceAdapter = $this->namespaceAdapterAdapter->fromRootInterfaceToNamespaceAdapter($interface);

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
                if (!$oneParameter->hasInterface()) {
                    $parametersCode[] = $name;
                    continue;
                }

                $interface = $oneParameter->getInterface();
                $interfaceName = $interface->getName();
                $parametersCode[] = $interfaceName.' '.$name;
                $includedNamespaces[] = $namespaceAdapter->fromInterfaceToNamespace($interface);
                continue;
            }

            $methodsCode[] = 'public function '.$methodName.'('.implode(', ', $parametersCode).');';
            continue;
        }

        $currentNamespace = $namespaceAdapter->fromInterfaceToNamespace($interface);
        $code = '<?php
namespace '.$currentNamespace.';
'.implode(PHP_EOL, $includedNamespaces).'

interface '.$name.' {
'.implode(PHP_EOL, $methodsCode).'
}';

        $relativeFilePath = '/'.str_replace('\\', '/', $currentNamespace).'/'.$name.'.php';
        return new ConcreteOutputCode($code, $relativeFilePath);
    }

}
