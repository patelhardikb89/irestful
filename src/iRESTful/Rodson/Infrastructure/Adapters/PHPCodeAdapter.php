<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\ObjectInterface;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteOutputCode;
use iRESTful\Rodson\Domain\Outputs\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Method;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters\PathAdapter;

final class PHPCodeAdapter implements CodeAdapter {
    private $pathAdapter;
    public function __construct(PathAdapter $pathAdapter) {
        $this->pathAdapter = $pathAdapter;
    }

    public function fromInterfaceToCode(ObjectInterface $interface) {

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

        $currentNamespace = implode('\\', $interface->getNamespace()->get());
        $code = '<?php
namespace '.$currentNamespace.';
'.implode(PHP_EOL, $includedNamespaces).'

interface '.$name.' {
'.implode(PHP_EOL, $methodsCode).'
}';

        $relativeFilePath = str_replace('\\', '/', $currentNamespace).'/'.$name.'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);
        return new ConcreteOutputCode($code, $path);
    }

    public function fromClassToCode(ObjectClass $class) {

        $codeProperties = function(array $properties) {
            $lines = [];
            foreach($properties as $oneProperty) {
                $lines[] = 'private $'.$oneProperty->get().';';
            }

            return implode(PHP_EOL, $lines);
        };

        $codeMethod = function(Method $classMethod) {

            $codeParameters = function(array $parameters) {

                $lines = [];
                foreach($parameters as $oneParameter) {
                    $name = $oneParameter->getName();

                    if (!$oneParameter->hasReturnedInterface()) {
                        $lines[] = '$'.$name;
                        continue;
                    }

                    $returnedInterface = $oneParameter->getReturnedInterface();
                    $typeName = $returnedInterface->getName();
                    $lines[] = $typeName.' $'.$name;
                }

                return implode(', ', $lines);

            };

            $code = $classMethod->getCode();
            $interfaceMethod = $classMethod->getInterfaceMethod();

            $methodName = $interfaceMethod->getName();
            if (!$interfaceMethod->hasParameters()) {
                return 'public function '.$methodName.'() {
                    '.$code.'
                }';
            }

            $methodParameters = $interfaceMethod->getParameters();
            return 'public function '.$methodName.'('.$codeParameters($methodParameters).') {
                '.$code.'
            }';
        };

        $codeConstructor = function(Method $constructor, array &$namespaces) use(&$codeMethod) {
            $interfaceMethod = $constructor->getInterfaceMethod();
            if (!$interfaceMethod->hasParameters()) {
                return [];
            }

            $methodParameters = $interfaceMethod->getParameters();
            foreach($methodParameters as $oneParameter) {
                if (!$oneParameter->hasReturnedInterface()) {
                    continue;
                }

                $returnedInterface = $oneParameter->getReturnedInterface();
                $namespaces[] = $returnedInterface->getNamespace();
            }

            return $codeMethod($constructor);

        };

        $codeMethods = function(array $methods) use(&$codeMethod) {

            $blocks = [];
            foreach($methods as $oneMethod) {
                $blocks[] = $codeMethod($oneMethod);
            }

            return implode(PHP_EOL.PHP_EOL, $blocks);
        };

        $includeNamespaces = function(array $namespaces) {

            $lines = [];
            foreach($namespaces as $oneNamespace) {
                $data = $oneNamespace->get();
                $lines[] = 'use '.implode('\\', $data).';';
            }

            $lines = array_unique($lines);
            return implode(PHP_EOL, $lines);

        };

        $name = $class->getName();
        $properties = $class->getProperties();

        $constructor = $class->getConstructor();
        $methods = $class->getMethods();

        $interface = $class->getInterface();
        $interfaceName = $interface->getName();
        $currentNamespace = implode('\\', $class->getNamespace()->get());

        $namespaces = [];
        $code = [
            'properties' => $codeProperties($properties),
            'constructor' => $codeConstructor($constructor, $namespaces),
            'methods' => $codeMethods($methods)
        ];

        $code = '<?php
                namespace '.$currentNamespace.';
                '.$includeNamespaces($namespaces).'

                final class '.$name.' implements '.$interfaceName.' {
                    '.$code['properties'].'
                    '.$code['constructor'].'

                    '.$code['methods'].'
                }
        ';

        $interfaceCode = $this->fromInterfaceToCode($interface);

        $relativeFilePath = str_replace('\\', '/', $currentNamespace).'/'.$name.'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);
        return new ConcreteOutputCode($code, $path, [$interfaceCode]);
    }

    public function fromClassesToCodes(array $classes) {
        $output = [];
        foreach($classes as $oneClass) {
            $output[] = $this->fromClassToCode($oneClass);
        }

        return $output;
    }

}
