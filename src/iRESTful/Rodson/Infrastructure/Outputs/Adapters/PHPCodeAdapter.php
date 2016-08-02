<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\ClassNamespace;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\ConcreteOutputCode;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Parameter as AnnotationParameter;

final class PHPCodeAdapter implements CodeAdapter {
    private $pathAdapter;
    public function __construct(PathAdapter $pathAdapter) {
        $this->pathAdapter = $pathAdapter;
    }

    public function fromAnnotatedClassToCodes(AnnotatedClass $annotatedClass) {

        $tab = '    ';
        $renderCodeLines = function(array $codeLines, $prefix = '') use(&$renderCodeLines, &$tab) {

            $output = '';
            foreach($codeLines as $oneCodeLine) {

                if (is_array($oneCodeLine)) {
                    $currentTab = $prefix.$tab;
                    $output .= $renderCodeLines($oneCodeLine, $currentTab);
                    continue;
                }

                $output .= $prefix.$oneCodeLine.PHP_EOL;
            }

            return $output;

        };

        $fromParametersToMethodSignatureCodeLine = function(array $parameters) {

            $getType = function(Type $type) {

                if ($type->isArray()) {
                    return 'array';
                }

                if ($type->hasNamespace()) {
                    $namespace = $type->getNamespace();
                    $namespaceName = $namespace->getName();
                    return $namespaceName;
                }

                return '';
            };

            $params = [];
            foreach($parameters as $oneParameter) {
                $name = $oneParameter->getName();
                $type = $oneParameter->getType();
                $isOptional = $oneParameter->isOptional();

                $element = trim($getType($type).' $'.$name);
                if ($isOptional) {
                    $element = $element.' = null';
                }

                $params[] = $element;
            }

            return implode(', ', $params);

        };

        $annotation = $annotatedClass->getAnnotation();
        $fromConstructorToCodeLines = function(Constructor $constructor) use(&$fromParametersToMethodSignatureCodeLine, &$annotation) {

            $fromParametersToSignatureCodeLine = function(array $parameters) use(&$fromParametersToMethodSignatureCodeLine) {

                $output = [];
                foreach($parameters as $oneParameter) {
                    $output[] = $oneParameter->getParameter();
                }

                return $fromParametersToMethodSignatureCodeLine($output);

            };

            $fromParametersToPropertiesCodeLines = function(array $parameters) {

                $lines = [];
                foreach($parameters as $oneParameter) {
                    $property = $oneParameter->getProperty();
                    $propertyName = $property->getName();
                    $lines[] = 'private $'.$propertyName.';';
                }

                return $lines;

            };

            $fromParametersToPropertiesAssignementCodeLines = function(array $parameters) {

                $lines = [];
                foreach($parameters as $oneParameter) {
                    $property = $oneParameter->getProperty();
                    $parameter = $oneParameter->getParameter();

                    $propertyName = $property->getName();
                    $parameterName = $parameter->getName();

                    $lines[] = '$this->'.$propertyName.' = $'.$parameterName.';';
                }

                return $lines;

            };

            $fromAnnotationToAnnotationCodeLines = function(Annotation $annotation) {

                $fromAnnotationParameterToCodeLine = function(AnnotationParameter $parameter) {

                    $flow = $parameter->getFlow();
                    $flowString = '@'.$flow->getPropertyName().' -> '.$flow->getMethodChain()->getChain().' -> '.$flow->getKeyname().' ';

                    $type = $parameter->getType();


                    $converterString = '';
                    if ($parameter->hasConverter()) {
                        $converter = $parameter->getConverter();

                        $databaseConverterString = '';
                        if ($converter->hasDatabaseConverter()) {
                            $databaseConverter = $converter->getDatabaseConverter();
                            $interfaceName = $databaseConverter->getInterfaceName();
                            $methodName = $databaseConverter->getMethodName();
                            $databaseConverterString = $interfaceName.'::'.$methodName;
                        }

                        $viewConverterString = '';
                        if ($converter->hasViewConverter()) {
                            $viewConverter = $converter->getViewConverter();
                            $interfaceName = $viewConverter->getInterfaceName();
                            $methodName = $viewConverter->getMethodName();
                            $viewConverterString = $interfaceName.'::'.$methodName;
                        }

                        if (!empty($databaseConverterString) && !empty($viewConverterString)) {
                            $converterString = $databaseConverterString.' || '.$viewConverterString;
                        }

                        if (!empty($databaseConverterString)) {
                            $converterString = $databaseConverterString;
                        }

                        $converterString = '** '.$converterString.' ';
                    }

                    $elementsTypeString = '';
                    if ($parameter->hasElementsType()) {
                        $elementsType = $parameter->getElementsType();
                        $elementsTypeString = '** @elements-type -> '.$elementsType.' ';
                    }

                    return '*   '.$flowString.$elementsTypeString.$converterString;

                };

                $output = [
                    '',
                    '/**'
                ];
                $parameters = $annotation->getParameters();
                foreach($parameters as $oneParameter) {
                    $output[] = $fromAnnotationParameterToCodeLine($oneParameter);
                }

                $output[] = '*/';
                return $output;
            };

            $name = $constructor->getName();
            $parameters = $constructor->getParameters();

            $propertiesCodeLines = $fromParametersToPropertiesCodeLines($parameters);
            $propertiesAssignmentCodeLines = $fromParametersToPropertiesAssignementCodeLines($parameters);
            $signatureCodeLine = $fromParametersToSignatureCodeLine($parameters);

            $annotationCodeLines = [];
            if (!empty($annotation)) {
                $annotationCodeLines = $fromAnnotationToAnnotationCodeLines($annotation);
            }

            return array_merge(
                $propertiesCodeLines,
                $annotationCodeLines,
                [
                    'public function '.$name.'('.$signatureCodeLine.') {',
                    $propertiesAssignmentCodeLines,
                    '}',
                    ''
                ]);
        };

        $fromConstructorParametersToCodeLines = function(array $constructorParameters) {

            $methods = [];
            foreach($constructorParameters as $oneConstructorParameter) {
                $method = $oneConstructorParameter->getMethod();
                $methodName = $method->getName();
                $returnedPropertyName = $oneConstructorParameter->getProperty()->getName();

                $methods = array_merge($methods, [
                    'public function '.$methodName.'() {',
                    ['return $this->'.$returnedPropertyName.';'],
                    '}',
                    ''
                ]);
            }

            return $methods;

        };

        $fromCustomMethodsToCodeLines = function(array $customMethods)  use(&$fromParametersToMethodSignatureCodeLine){
            $methods = [];
            foreach($customMethods as $oneCustomMethod) {

                $methodName = $oneCustomMethod->getName();
                $parameters = $oneCustomMethod->getParameters();
                $signature = $fromParametersToMethodSignatureCodeLine($parameters);

                $sourceCodeLines = [];
                if ($oneCustomMethod->hasSourceCodeLines()) {
                    $sourceCodeLines = $oneCustomMethod->getSourceCodeLines();
                }

                $methods = array_merge($methods, [
                    'public function '.$methodName.'('.$signature.') {',
                    $sourceCodeLines,
                    '}',
                    ''
                ]);
            }

            return $methods;
        };

        $fromClassToUseNamespaces = function(ObjectClass $class) {

            $fromInterfaceToUseNamespaces = function(ClassInterface $interface) {
                if ($interface->isEntity()) {
                    return [
                        'use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;',
                        'use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;'
                    ];
                }

                return [];
            };

            $fromConstructorToUseNamespaces = function(Constructor $constructor) {

                $fromParametersToUseNamespaces = function(array $parameters) {
                    $output = [];
                    foreach($parameters as $oneParameter) {
                        $parameter = $oneParameter->getParameter();
                        $parameterType = $parameter->getType();
                        if ($parameterType->hasNamespace()) {
                            $parameterTypeNamespace = $parameterType->getNamespace();
                            $output[] = 'use '.implode('\\', $parameterTypeNamespace->getAll()).';';
                        }
                    }

                    return $output;
                };

                $parameters = $constructor->getParameters();
                return $fromParametersToUseNamespaces($parameters);
            };

            $constructor = $class->getConstructor();
            $interface = $class->getInterface();


            return array_merge(
                $fromInterfaceToUseNamespaces($interface),
                $fromConstructorToUseNamespaces($constructor)
            );

        };

        $fromInterfaceToCodeLines = function(ClassInterface $interface) {

            $fromMethodsToCodeLines = function(array $methods) {
                $output = [];
                foreach($methods as $oneMethod) {
                    $name = $oneMethod->getName();
                    $output[] = 'public function '.$name.'();';
                }

                return $output;
            };

            $fromInterfaceToUseNamespace = function(ClassInterface $interface) {

                $fromMethodsToUseNamespace = function(array $methods) {

                    $fromParametersToUseNamespace = function(array $parameters) {

                        $output = [];
                        foreach($parameters as $oneParameter) {
                            if ($oneParameter->hasNamespace()) {
                                $namespace = $oneParameter->getNamespace();
                                $output[] = 'use '.implode('\\', $namespace->getAll()).';';
                            }
                        }

                        return $output;

                    };

                    $output = [];
                    foreach($methods as $oneMethod) {

                        if ($oneMethod->hasParameters()) {
                            $parameters = $oneMethod->getParameters();
                            $output = array_merge($output, $fromParametersToUseNamespace($parameters));
                        }

                    }

                    return $output;
                };

                $output = [];
                if ($interface->isEntity()) {
                    $output[] = 'use iRESTful\Objects\Entities\Entities\Domain\Entity;';
                }

                $methods = $interface->getMethods();
                return array_merge(
                    $output,
                    $fromMethodsToUseNamespace($methods)
                );

            };

            $name = $interface->getName();
            $methods = $interface->getMethods();
            $namespace = $interface->getNamespace();

            $useNamespaces = $fromInterfaceToUseNamespace($interface);
            $methodCodeLines = $fromMethodsToCodeLines($methods);
            $baseInterface = $interface->isEntity() ? ' extends Entity' : '';

            return [
                '<?php',
                'namespace '.implode('\\', $namespace->getPath()).';',
                implode(PHP_EOL, $useNamespaces).PHP_EOL,
                'interface '.$name.$baseInterface.' {',
                $methodCodeLines,
                '}',
                ''
            ];

        };

        $pathAdapter = $this->pathAdapter;
        $getPath = function(ClassNamespace $namespace) use(&$pathAdapter) {
            $relativeFilePath = implode('/', $namespace->getAll()).'.php';
            return $pathAdapter->fromRelativePathStringToPath($relativeFilePath);
        };

        $createSourceCode = function(AnnotatedClass $annotatedClass) use(&$fromConstructorToCodeLines, &$fromClassToUseNamespaces, &$fromConstructorParametersToCodeLines, &$fromCustomMethodsToCodeLines, &$renderCodeLines) {

            $class = $annotatedClass->getClass();
            $name = $class->getName();
            $interface = $class->getInterface();
            $constructor = $class->getConstructor();

            $constructorCodeLines = $fromConstructorToCodeLines($constructor);
            $useInterfaces = $fromClassToUseNamespaces($class);

            $parameters = $constructor->getParameters();
            $getterCodeLines = $fromConstructorParametersToCodeLines($parameters);

            $customCodeLines = [];
            if ($class->hasCustomMethods()) {
                $customMethods = $class->getCustomMethods();
                $customCodeLines = $fromCustomMethodsToCodeLines($customMethods);
            }

            $interfaceName = $interface->getName();
            $subClass = ($interface->isEntity()) ? 'AbstractEntity' : '';

            $useInterfaceCode = '';
            if (!empty($useInterfaces)) {
                $useInterfaceCode = implode(PHP_EOL, $useInterfaces);
            }

            $classAnnotationCode = [];
            if ($annotatedClass->hasAnnotation()) {
                $annotation = $annotatedClass->getAnnotation();

                $containerName = $annotation->getContainerName();
                $classAnnotationCodeLines = [
                    '/**',
                    '*   @container -> '.$containerName,
                    '*/'
                ];

                $classAnnotationCode = implode(PHP_EOL, $classAnnotationCodeLines);
            }

            $classCodeLines = [
                '<?php',
                'namespace '.implode('\\', $class->getNamespace()->getPath()).';',
                $useInterfaceCode,
                '',
                $classAnnotationCode,
                'final class '.$name.' extends '.$subClass.' implements '.$interfaceName.' {',
                $constructorCodeLines,
                $getterCodeLines,
                $customCodeLines,
                '}'
            ];

            return $renderCodeLines($classCodeLines);
        };

        $createInterfaceCode = function(ClassInterface $interface) use(&$getPath, &$renderCodeLines, &$fromInterfaceToCodeLines) {

            $interfaceCodeLines = $fromInterfaceToCodeLines($interface);
            $sourceCode = $renderCodeLines($interfaceCodeLines);

            $namespace = $interface->getNamespace();
            $path = $getPath($namespace);

            return new ConcreteOutputCode($sourceCode, $path);

        };

        $class = $annotatedClass->getClass();
        $interface = $class->getInterface();
        $namespace = $class->getNamespace();

        $classSourceCode = $createSourceCode($annotatedClass);
        $path = $getPath($namespace);

        $interfaceCode = $createInterfaceCode($interface);
        return new ConcreteOutputCode($classSourceCode, $path, [$interfaceCode]);
    }

    public function fromAnotatedClassesToCodes(array $classes) {
        $output = [];
        foreach($classes as $oneClass) {
            $output[] = $this->fromAnnotatedClassToCodes($oneClass);
        }

        return $output;
    }

}
