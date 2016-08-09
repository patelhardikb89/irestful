<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\ConcreteOutputCode;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Parameter as AnnotationParameter;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Tests\Functionals\Transforms\TransformTest;
use iRESTful\Rodson\Domain\Middles\Samples\Sample;

final class PHPCodeAdapter implements CodeAdapter {
    private $pathAdapter;
    private $tab;
    public function __construct(PathAdapter $pathAdapter) {
        $this->pathAdapter = $pathAdapter;
        $this->tab = '    ';
    }

    public function fromAnnotatedClassToCodes(AnnotatedClass $annotatedClass) {

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
        $interface = $annotatedClass->getClass()->getInterface();
        $fromConstructorToCodeLines = function(Constructor $constructor) use(&$fromParametersToMethodSignatureCodeLine, &$annotation, &$interface) {

            $fromParametersToSignatureCodeLine = function(array $parameters) use(&$fromParametersToMethodSignatureCodeLine, &$interface) {

                $output = [];
                foreach($parameters as $oneParameter) {
                    $output[] = $oneParameter->getParameter();
                }

                if ($interface->isEntity()) {
                    return 'Uuid $uuid, \DateTime $createdOn, '.$fromParametersToMethodSignatureCodeLine($output);
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

            $fromParametersToPropertiesAssignementCodeLines = function(array $parameters) use(&$interface) {

                $validatePrimitive = function($name, $primitive, $isOptional) {

                    if ($primitive == 'boolean') {
                        return [];
                    }

                    $fn = 'is_string';
                    if ($primitive == 'integer') {
                        $fn = 'is_integer';
                    }

                    if ($primitive == 'float') {
                        $fn = 'is_float';
                    }

                    if ($isOptional) {
                        return [
                            'if (!is_null($'.$name.') && !'.$fn.'($'.$name.')) {',
                            [
                                'throw new \Exception("The '.$name.' must be a '.$primitive.' if non-null.");'
                            ],
                            '}'
                        ];
                    }

                    return [
                        'if (is_null($'.$name.') || !'.$fn.'($'.$name.')) {',
                        [
                            'throw new \Exception("The '.$name.' must be a non-null '.$primitive.'.");'
                        ],
                        '}',
                        ''
                    ];
                };

                $lines = [];
                foreach($parameters as $oneParameter) {
                    $parameter = $oneParameter->getParameter();
                    $parameterType = $parameter->getType();

                    if ($parameterType->hasPrimitive()) {
                        $parameterName = $parameter->getName();
                        $primitive = $parameterType->getPrimitive();
                        $isOptional = $parameter->isOptional();
                        $lines = array_merge($lines, $validatePrimitive($parameterName, $primitive, $isOptional));
                    }
                }

                if ($interface->isEntity()) {
                    $lines[] = 'parent::__construct($uuid, $createdOn);';
                }

                foreach($parameters as $oneParameter) {
                    $property = $oneParameter->getProperty();
                    $parameter = $oneParameter->getParameter();

                    $propertyName = $property->getName();
                    $parameterName = $parameter->getName();
                    $parameterType = $parameter->getType();

                    if ($parameterType->hasPrimitive()) {
                        $primitive = $parameterType->getPrimitive();
                        if ($primitive == 'boolean') {
                            $lines[] = '$this->'.$propertyName.' = (bool) $'.$parameterName.';';
                            continue;
                        }
                    }

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
            $signatureCodeLine = '';
            $propertiesCodeLines = [];
            $propertiesAssignmentCodeLines = [];
            if ($constructor->hasParameters()) {
                $parameters = $constructor->getParameters();
                $propertiesCodeLines = $fromParametersToPropertiesCodeLines($parameters);
                $propertiesAssignmentCodeLines = $fromParametersToPropertiesAssignementCodeLines($parameters);
                $signatureCodeLine = $fromParametersToSignatureCodeLine($parameters);
            }


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

                if (!$constructor->hasParameters()) {
                    return [];
                }

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
                'namespace '.$namespace->getPathAsString().';',
                implode(PHP_EOL, $useNamespaces).PHP_EOL,
                'interface '.$name.$baseInterface.' {',
                $methodCodeLines,
                '}',
                ''
            ];

        };

        $createClassSourceCode = function(ObjectClass $class) use(&$fromConstructorToCodeLines, &$fromClassToUseNamespaces, &$fromConstructorParametersToCodeLines, &$fromCustomMethodsToCodeLines) {

            $name = $class->getName();
            $interface = $class->getInterface();
            $constructor = $class->getConstructor();

            $constructorCodeLines = $fromConstructorToCodeLines($constructor);
            $useInterfaces = $fromClassToUseNamespaces($class);

            $getterCodeLines = [];
            if ($constructor->hasParameters()) {
                $parameters = $constructor->getParameters();
                $getterCodeLines = $fromConstructorParametersToCodeLines($parameters);
            }

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

            $classCodeLines = [
                '<?php',
                'namespace '.$class->getNamespace()->getPathAsString().';',
                $useInterfaceCode,
                '',
                'final class '.$name.' extends '.$subClass.' implements '.$interfaceName.' {',
                $constructorCodeLines,
                $getterCodeLines,
                $customCodeLines,
                '}'
            ];

            return $classCodeLines;
        };

        $createAnnotatedClassSourceCode = function(AnnotatedClass $annotatedClass) use(&$fromConstructorToCodeLines, &$fromClassToUseNamespaces, &$fromConstructorParametersToCodeLines, &$fromCustomMethodsToCodeLines) {

            $class = $annotatedClass->getClass();
            $name = $class->getName();
            $interface = $class->getInterface();
            $constructor = $class->getConstructor();

            $constructorCodeLines = $fromConstructorToCodeLines($constructor);
            $useInterfaces = $fromClassToUseNamespaces($class);

            $getterCodeLines = [];
            if ($constructor->hasParameters()) {
                $parameters = $constructor->getParameters();
                $getterCodeLines = $fromConstructorParametersToCodeLines($parameters);
            }

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

            $classAnnotationCode = '';
            if ($annotatedClass->hasAnnotation()) {
                $annotation = $annotatedClass->getAnnotation();
                if ($annotation->hasContainerName()) {
                    $containerName = $annotation->getContainerName();
                    $classAnnotationCodeLines = [
                        '/**',
                        '*   @container -> '.$containerName,
                        '*/'
                    ];
                    $classAnnotationCode = implode(PHP_EOL, $classAnnotationCodeLines);
                }


            }

            $classCodeLines = [
                '<?php',
                'namespace '.$class->getNamespace()->getPathAsString().';',
                $useInterfaceCode,
                '',
                $classAnnotationCode,
                'final class '.$name.' extends '.$subClass.' implements '.$interfaceName.' {',
                $constructorCodeLines,
                $getterCodeLines,
                $customCodeLines,
                '}'
            ];

            return $classCodeLines;
        };

        $createSubClassesCodes = function(ObjectClass $class) use(&$createSubClassesCodes, &$createClassSourceCode) {

            if (!$class->hasSubClasses()) {
                return [];
            }

            $output = [];
            $subClasses = $class->getSubClasses();
            foreach($subClasses as $oneSubClass) {

                $namespace = $oneSubClass->getNamespace();
                $path = $this->getFilePathPath($namespace);

                $classSourceCodeLines = $createClassSourceCode($oneSubClass);
                $classSourceCode = $this->renderCodeLines($classSourceCodeLines);

                $subSubClasses = $createSubClassesCodes($oneSubClass);
                if (empty($subSubClasses)) {
                    $subSubClasses = null;
                }

                $output[] = new ConcreteOutputCode($classSourceCode, $path, $subSubClasses);
            }

            return $output;
        };

        $class = $annotatedClass->getClass();
        $interface = $class->getInterface();
        $namespace = $class->getNamespace();

        $classSourceCodeLines = $createAnnotatedClassSourceCode($annotatedClass);
        $classSourceCode = $this->renderCodeLines($classSourceCodeLines);
        $path = $this->getFilePathPath($namespace);

        $interfaceCodeLines = $fromInterfaceToCodeLines($interface);
        $interfaceSourceCode = $this->renderCodeLines($interfaceCodeLines);
        $interfaceNamespace = $interface->getNamespace();
        $interfacePath = $this->getFilePathPath($interfaceNamespace);
        $interfaceCode = new ConcreteOutputCode($interfaceSourceCode, $interfacePath);

        $subClasses = $createSubClassesCodes($class);
        $subClasses = array_merge($subClasses, [$interfaceCode]);

        return new ConcreteOutputCode($classSourceCode, $path, $subClasses);
    }

    public function fromAnotatedClassesToCodes(array $classes) {
        $output = [];
        foreach($classes as $oneClass) {
            $output[] = $this->fromAnnotatedClassToCodes($oneClass);
        }

        return $output;
    }

    public function fromConfigurationToCode(Configuration $configuration) {

        $getMapperCodeLines = function(array $mapper) {

            $output = [];
            foreach($mapper as $keyname => $element) {
                $output[] = "'".$keyname."' => '".$element."'";
            }

            return explode(PHP_EOL, implode(','.PHP_EOL, $output));

        };

        $getTransformerCodeLines = function(array $elements) {
            $mapper = [];
            foreach($elements as $keyname => $element) {
                $mapper[] = "'".$keyname."' => new \\".$element."(),";
            }

            $mapper[] = "'iRESTful\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => ".'new \iRESTful\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter($this->getTimezone()),';
            $mapper[] = "'iRESTful\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => ".'new \iRESTful\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter()';
            return $mapper;
        };

        $namespace = $configuration->getNamespace();
        $containerClassMapper = $configuration->getContainerClassMapper();
        $interfaceClassMapper = $configuration->getInterfaceClassMapper();
        $adapterInterfaceClassMapper = $configuration->getAdapterInterfaceClassMapper();

        $classCodeLines = [
            '<?php',
            'namespace '.$namespace->getPathAsString().';',
            'use iRESTful\Objects\Entities\Entities\Configurations\EntityConfiguration;',
            '',
            'final class '.$namespace->getName().' implements EntityConfiguration {',
            '',
            [
                'public function __construct() {',
                    [
                        ''
                    ],
                '}',
                '',
                'public function getDelimiter() {',
                    [
                        "return '".$configuration->getDelimiter()."';",
                    ],
                '}',
                '',
                'public function getTimezone() {',
                    [
                        "return '".$configuration->getTimezone()."';",
                    ],
                '}',
                '',
                'public function getContainerClassMapper() {',
                    [
                        'return [',
                        $getMapperCodeLines($containerClassMapper),
                        '];'
                    ],
                '}',
                '',
                'public function getInterfaceClassMapper() {',
                    [
                        'return [',
                        $getMapperCodeLines($interfaceClassMapper),
                        '];'
                    ],
                '}',
                '',
                'public function getTransformerObjects() {',
                    [
                        'return [',
                        $getTransformerCodeLines($adapterInterfaceClassMapper),
                        '];'
                    ],
                '}'
            ],
            '}'
        ];

        $path = $this->getFilePathPath($namespace);
        $configurationCode = $this->renderCodeLines($classCodeLines);
        return new ConcreteOutputCode($configurationCode, $path);
    }

    public function fromFunctionalTransformTestsToCodes(array $functionalTransformTests) {
        $output = [];
        foreach($functionalTransformTests as $oneFunctionalTransformTest) {
            $output[] = $this->fromFunctionalTransformTestToCode($oneFunctionalTransformTest);
        }

        return $output;
    }

    public function fromFunctionalTransformTestToCode(TransformTest $functionalTransformTest) {

        $namespace = $functionalTransformTest->getNamespace();
        $configuration = $functionalTransformTest->getConfiguration();

        $getHelpersCodeLines = function(array $samples) use(&$configuration) {

            $configsName = $configuration->getNamespace()->getName();

            $getOneData = function(Sample $sample) {

                $getData = function(array $data) use(&$getData) {

                    $lines = [];
                    $keynames = array_keys($data);
                    $lastKeyname = array_pop($keynames);
                    foreach($data as $keyname => $element) {

                        $delimiter = ($keyname != $lastKeyname) ? ',' : '';

                        if (is_string($keyname)) {
                            $keyname = "'".$keyname."'";
                        }

                        if (is_array($element)) {
                            $lines[] = $keyname.' => [';
                            $lines[] = $getData($element);
                            $lines[] = ']'.$delimiter;
                            continue;
                        }

                        if (is_numeric($element)) {
                            $lines[] = $keyname.' => '.$element.$delimiter;
                            continue;
                        }

                        $lines[] = $keyname." => '".$element."'".$delimiter;

                    }

                    return $lines;
                };

                return [
                    "'container' => '".$sample->getContainerName()."',",
                    "'data' => [",
                    $getData($sample->getData()),
                    ']'
                ];
            };

            $getData = function(array $samples) use(&$getOneData) {
                $output = [];
                $amountSamples = count($samples);
                foreach($samples as $index => $oneSample) {

                    $delimiter = (($index + 1) >= $amountSamples) ? '' : ',';

                    $output[] = '[';
                    $output[] = $getOneData($oneSample);
                    $output[] = ']'.$delimiter;
                }

                return $output;
            };

            return [
                '$configs = new '.$configsName.'();',
                '$data = [',
                $getData($samples),
                '];',
                '',
                '$this->helpers = [];',
                'foreach($data as $oneData) {',
                [
                    '$this->helpers[] = new ConversionHelper($this, $configs, $oneData);'
                ],
                '}'
            ];

        };

        $generateTestMethods = function($amountOfMethods) {

            $output = [];
            for($i = 0; $i < $amountOfMethods; $i++) {
                $output[] = 'public function testConvert'.$i.'_Success() {';
                $output[] = [
                    '$this->helpers['.$i.']->execute();'
                ];
                $output[] = '}';
                $output[] = '';
            }

            return $output;

        };

        $samples = $functionalTransformTest->getSamples();
        $classCodeLines = [
            '<?php',
            'namespace '.$namespace->getPathAsString().';',
            'use '.$configuration->getNamespace()->getAllAsString().';',
            'use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;',
            '',
            'final class '.$namespace->getName().' extends \PHPUnit_Framework_TestCase {',
                [
                    'private $helpers;',
                    'public function setUp() {',
                    $getHelpersCodeLines($samples),
                    '}',
                    '',
                    'public function tearDown() {',
                        [
                            '$this->helpers = null;'
                        ],
                    '}',
                ],
                '',
                $generateTestMethods(count($samples)),
            '}'
        ];

        $path = $this->getFilePathPath($namespace);
        $classCode = $this->renderCodeLines($classCodeLines);
        return new ConcreteOutputCode($classCode, $path);

    }

    private function renderCodeLines(array $codeLines, $prefix = '') {
        $output = '';
        foreach($codeLines as $oneCodeLine) {

            if (is_array($oneCodeLine)) {
                $currentTab = $prefix.$this->tab;
                $output .= $this->renderCodeLines($oneCodeLine, $currentTab);
                continue;
            }

            $output .= $prefix.$oneCodeLine.PHP_EOL;
        }

        return $output;
    }

    private function getFilePathPath(ClassNamespace $namespace) {
        $relativeFilePath = implode('/', $namespace->getAll()).'.php';
        return $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);
    }

}
