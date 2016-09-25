<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Exceptions\CustomMethodException;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassMethodCustom;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Method as CodeMethod;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Converter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Instruction;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\HttpRequest;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Url;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Actions\Action as HttpRequestAction;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Insert;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Delete;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Update;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Entity;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\MultipleEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Container;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Type as ConverterType;

final class ConcreteClassMethodCustomAdapter implements CustomMethodAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    private function getCodeFromValue(Value $value) {
        if ($value->hasInputVariable()) {
            $variableName = $value->getInputVariable();
            return 'isset($input["'.$variableName.'"]) ? $input["'.$variableName.'"] : null';
        }

        if ($value->hasEnvironmentVariable()) {
            $variableName = $value->getEnvironmentVariable();
            return 'getenv("'.$variableName.'")';
        }

        if ($value->hasDirect()) {
            $directValue = $value->getDirect();
            return "'".$directValue."'";
        }

        //throws
    }

    private function generateArrayCode(array $params = null) {
        if (empty($params)) {
            return '[]';
        }

        $data = [];
        foreach($params as $keyname => $value) {
            $data[$keyname] = (is_string($value)) ? '$'.$value : $this->getCodeFromValue($value);
        }

        $middleLines = [];
        foreach($data as $keyname => $oneLine) {

            if (is_numeric($keyname)) {
                $middleLines[] = $oneLine;
                continue;
            }

            $middleLines[] = '"'.$keyname.'" => '.$oneLine;
        }

        return '['.implode(', ', $middleLines).']';
    }

    private function getHttpMethodFromAction(HttpRequestAction $action) {
        if ($action->isInsert()) {
            return 'post';
        }

        if ($action->isUpdate()) {
            return 'put';
        }

        if ($action->isDelete()) {
            return 'delete';
        }

        return 'get';
    }

    private function generateCodeLinesFromHttpRequest(HttpRequest $httpRequest) {
        $command = $httpRequest->getCommand();
        $action = $command->getAction();
        $url = $command->getUrl();

        $baseUrl = $url->getBaseUrl();
        $uri = $url->getEndpoint();
        $httpMethod = $this->getHttpMethodFromAction($action);
        $port = $url->hasPort() ? $url->getPort() : 80;
        $query = $this->generateArrayCode($httpRequest->getQueryParameters());
        $request = $this->generateArrayCode($httpRequest->getRequestParameters());
        $headers = $this->generateArrayCode($httpRequest->getHeaders());

        $output = [
            '$response = $this->httpApplicationFactoryAdapter->fromDataToHttpApplicationFactory([',
            [
                "'base_url' => '".$baseUrl."'"
            ],
            '])->execute([',
            [
                "'uri' => '".$uri."',",
                "'method' => '".$httpMethod."',",
                "'port' => '".$port."',",
                "'query_parameters' => ".$query.",",
                "'request_parameters' => ".$request.",",
                "'headers' => ".$headers
            ],
            ']);',
            '',
            '$code = $response->getCode();',
            'if ($code != 200) {',
            [
                '$content = $response->getContent();',
                'throw new \Exception(\'There was an exception while executing http request command: '.$httpMethod.' '.$baseUrl.$uri.':'.$port.'.  The response code was: \'.$code.\'.  The content was: \'.$content);'
            ],
            '}',
            ''
        ];

        if ($action->isRetrieval()) {

            if (!$httpRequest->getView()->isJson()) {
                throw new CustomMethodException('The given httpRequest contains a view that is not yet supported.');
            }

            $output[] = '$json = $response->getContent();';
            $output[] = 'json_encode($json, true);';
        }

        return $output;
    }

    private function getContainerNameFromContainer(Container $container) {
        if ($container->hasAnnotatedEntity()) {
            $annotatedEntity = $container->getAnnotatedEntity();
            $containerName = $annotatedEntity->getAnnotation()->getContainerName();
            return "'".$containerName."'";
        }

        $value = $container->getValue();
        return $this->getCodeFromValue($value);
    }

    private function generateCodeLinesFromEntity(Entity $entity) {

        $container = $entity->getContainer();
        $containerName = $this->getContainerNameFromContainer($container);


        if ($entity->hasUuidValue()) {
            $uuidValue = $entity->getUuidValue();
            $uuidCode = $this->getCodeFromValue($uuidValue);

            return [
                '$this->entityRepositoryFactory->create()->retrieve([',
                [
                    "'container' => ".$containerName,
                    "'uuid' => ".$uuidCode
                ],
                ']);'
            ];
        }

        if ($entity->hasKeyname()) {
            $keyname = $entity->getKeyname();
            $name = $keyname->getName();
            $value = $keyname->getValue();

            return [
                '$this->entityRepositoryFactory->create()->retrieve([',
                [
                    "'container' => '".$containerName."'",
                    "'keyname' => [",
                    [
                        "'name' => ".$this->getCodeFromValue($name),
                        "'value' => ".$this->getCodeFromValue($value)
                    ],
                    "]"
                ],
                ']);'
            ];
        }

        //throws

    }

    private function generateCodeLinesFromMultipleEntity(MultipleEntity $multipleEntity) {

        $container = $multipleEntity->getContainer();
        $containerName = $this->getContainerNameFromContainer($container);

        if ($multipleEntity->hasUuidValue()) {
            $uuidValue = $multipleEntity->getUuidValue();
            return [
                '$this->entitySetRepositoryFactory->create()->retrieve([',
                [
                    "'container' => ".$containerName,
                    "'uuids' => ".$this->getCodeFromValue($uuidValue)
                ],
                ']);'
            ];
        }

        if ($multipleEntity->hasKeyname()) {
            $keyname = $multipleEntity->getKeyname();
            $name = $keyname->getName();
            $value = $keyname->getValue();

            return [
                '$this->entitySetRepositoryFactory->create()->retrieve([',
                [
                    "'container' => '".$containerName."'",
                    "'keyname' => [",
                    [
                        "'name' => ".$this->getCodeFromValue($name),
                        "'value' => ".$this->getCodeFromValue($value)
                    ],
                    ']'
                ],
                ']);'
            ];
        }

        //throws
    }

    private function generateCodeLinesFromEntityPartialSet(EntityPartialSet $entityPartialSet) {

        $container = $entityPartialSet->getContainer();
        $containerName = $this->getContainerNameFromContainer($container);

        $index = $entityPartialSet->getIndexValue();
        $amount = $entityPartialSet->getAmountValue();

        return [
            '$this->entityPartialSetFactory->create()->retrieve([',
            [
                '\'container\' => '.$containerName.',',
                '\'index\' => '.$this->getCodeFromValue($index).',',
                '\'amount\' => '.$this->getCodeFromValue($amount).','
            ],
            ']);'
        ];
    }

    private function generateCodeLinesFromRetrieval(Retrieval $retrieval) {

        if ($retrieval->hasHttpRequest()) {
            $httpRequest = $retrieval->getHttpRequest();
            return $this->generateCodeLinesFromHttpRequest($httpRequest);
        }

        if ($retrieval->hasEntity()) {
            $entity = $retrieval->getEntity();
            return $this->generateCodeLinesFromEntity($entity);
        }

        if ($retrieval->hasMultipleEntities()) {
            $multipleEntities = $retrieval->getMultipleEntities();
            return $this->generateCodeLinesFromMultipleEntity($multipleEntities);
        }

        if ($retrieval->hasEntityPartialSet()) {
            $entityPartialSet = $retrieval->getEntityPartialSet();
            return $this->generateCodeLinesFromEntityPartialSet($entityPartialSet);
        }

        //throws

    }

    private function generateCodeLinesFromDatabase(Database $database) {

        if ($database->hasRetrieval()) {
            $retrieval = $database->getRetrieval();
            return $this->generateCodeLinesFromRetrieval($retrieval);
        }

        if ($database->hasAction()) {
            $action = $database->getAction();
            return $this->generateCodeLinesFromAction($action);
        }

        //throws
    }

    private function generateCodeLinesFromAction(Action $action) {

        $generateCodeLinesFromInsert = function(Insert $insert) {
            if ($insert->hasAssignment()) {
                $variableName = $insert->getAssignment()->getVariableName();
                return [
                    '$this->entityServiceFactory->create()->insert($'.$variableName.');'
                ];
            }

            if ($insert->hasAssignments()) {
                $variables = [];
                $assignments = $insert->getAssignments();
                foreach($assignments as $oneAssignment) {
                    $variables[] = $oneAssignment->getVariableName();
                }

                return [
                    '$this->entitySetServiceFactory->create()->insert('.$this->generateArrayCode($variables).');'
                ];
            }

            //throws

        };

        $generateCodeLinesFromDelete = function(Delete $delete) {
            if ($delete->hasAssignment()) {
                $variableName = $delete->getAssignment()->getVariableName();
                return [
                    '$this->entityServiceFactory->create()->delete($'.$variableName.');'
                ];
            }

            if ($delete->hasAssignments()) {
                $variables = [];
                $assignments = $delete->getAssignments();
                foreach($assignments as $oneAssignment) {
                    $variables[] = $oneAssignment->getVariableName();
                }

                return [
                    '$this->entitySetServiceFactory->create()->delete('.$this->generateArrayCode($variables).');'
                ];
            }

            //throws
        };

        $generateCodeLinesFromUpdate = function(Update $update) {
            $source = $update->getSource();
            $updated = $update->getUpdated();

            $sourceVariableName = $source->getVariableName();
            $updatedVariableName = $updated->getVariableName();

            $newCodeLines[] = '$this->entityServiceFactory->create()->update($'.$sourceVariableName.', $'.$updatedVariableName.');';
            return $newCodeLines;

        };

        if ($action->hasHttpRequest()) {
            $httpRequest = $action->getHttpRequest();
            return $this->generateCodeLinesFromHttpRequest($httpRequest);
        }

        if ($action->hasInsert()) {
            $insert = $action->getInsert();
            return $generateCodeLinesFromInsert($insert);
        }

        if ($action->hasUpdate()) {
            $update = $action->getUpdate();
            return $generateCodeLinesFromUpdate($update);
        }

        if ($action->hasDelete()) {
            $delete = $action->getDelete();
            return $generateCodeLinesFromDelete($delete);
        }

        //throws
    }

    private function generateCodeLineFromConversion(Conversion $conversion) {

        $from = $conversion->from();
        $to = $conversion->to();

        if ($from->isInput() && $to->hasContainer()) {

            $input = '$input';
            $container = $to->getContainer();
            if ($container->hasValue()) {
                $value = $container->getValue();

                $input = $this->generateArrayCode([
                    'container' => $value,
                    'data' => 'input'
                ]);
            }

            if ($to->isMultiple()) {
                return '$this->entityAdapterFactory->create()->fromDataToEntities('.$input.');';
            }

            if ($to->isPartialSet()) {
                return '$this->entityAdapterFactory->create()->fromDataToEntityPartialSet('.$input.');';
            }

            return '$this->entityAdapterFactory->create()->fromDataToEntity('.$input.');';
        }

        if ($from->hasAssignment() && $to->isData()) {
            $assignment = $from->getAssignment();
            $variableName = $assignment->getVariableName();
            if ($assignment->isMultipleEntities()) {
                return '$this->entityAdapterFactory->create()->fromEntitiesToData($'.$variableName.');';
            }

            if ($assignment->isPartialEntitySet()) {
                return '$this->entityAdapterFactory->create()->fromEntityPartialSetToData($'.$variableName.');';
            }

            return '$this->entityAdapterFactory->create()->fromEntityToData($'.$variableName.');';
        }

        if ($from->isData() && $to->hasContainer() && $from->hasAssignment()) {

            $assignment = $from->getAssignment();
            $input = $assignment->getVariableName();

            $container = $to->getContainer();
            if ($container->hasValue()) {
                $value = $container->getValue();

                $input = $this->generateArrayCode([
                    'container' => $value,
                    'data' => $input
                ]);
            }


            if ($assignment->isMultipleEntities()) {
                return '$this->entityAdapterFactory->create()->fromDataToEntities('.$input.');';
            }

            if ($assignment->isPartialEntitySet()) {
                return '$this->entityAdapterFactory->create()->fromDataToEntityPartialSet('.$input.');';
            }

            return '$this->entityAdapterFactory->create()->fromDataToEntity('.$input.');';
        }

        //throws
    }

    private function generateCodeLineFromMergedAssignments(array $mergedAssignments) {

        $variableNames = [];
        foreach($mergedAssignments as $oneMergedAssignment) {
            $variableNames[] = '$'.$oneMergedAssignment->getVariableName();
        }

        return 'array_merge('.implode(', ', $variableNames).');';
    }

    private function generateCodeLinesFromAssignment(Assignment $assignment) {
        $variableName = $assignment->getVariableName();
        if ($assignment->hasDatabase()) {
            $database = $assignment->getDatabase();
            $codeLines = $this->generateCodeLinesFromDatabase($database);
            if (!empty($codeLines) && $database->hasRetrieval()) {
                $index = 0;
                $keys = array_keys($codeLines);
                $retrieval = $database->getRetrieval();
                if ($retrieval->hasHttpRequest()) {
                    $index = count($keys) - 1;
                }

                $codeLines[$keys[$index]] = '$'.$variableName.' = '.$codeLines[$keys[$index]];
            }

            return $codeLines;
        }

        if ($assignment->hasConversion()) {
            $conversion = $assignment->getConversion();
            $codeLine = $this->generateCodeLineFromConversion($conversion);
            return [
                '$'.$variableName.' = '.$codeLine
            ];
        }

        if ($assignment->hasMergedAssignments()) {
            $mergedAssignments = $assignment->getMergedAssignments();
            $codeLine = $this->generateCodeLineFromMergedAssignments($mergedAssignments);
            return [
                '$'.$variableName.' = '.$codeLine
            ];
        }

        //throws
    }

    private function generateCodeLinesFromInstruction(Instruction $instruction) {
        if ($instruction->hasMergeAssignments()) {
            $mergedAssignments = $instruction->getMergeAssignments();
            $codeLine = $this->generateCodeLineFromMergedAssignments($mergedAssignments);
            return [
                'return '.$codeLine
            ];
        }

        if ($instruction->hasAssignment()) {
            $assignment = $instruction->getAssignment();
            return $this->generateCodeLinesFromAssignment($assignment);
        }

        if ($instruction->hasAction()) {
            $action = $instruction->getAction();
            return $this->generateCodeLinesFromAction($action);
        }

        //throws
    }

    private function getSourceCodeLines(array $instructions) {

        $tab = '    ';
        $process = function(array $lines, $currentTab = '') use(&$tab, &$process) {

            $output = '';
            $newTab = $currentTab.$tab;
            foreach($lines as $oneLine) {
                if (is_array($oneLine)) {
                    $output .= $process($oneLine, $newTab);
                    continue;
                }

                $output .= $currentTab.$oneLine.PHP_EOL;
            }

            return $output;

        };

        $lines = [
            '$input = [];',
            'if ($request->hasParameters()) {',
            [
                '$input = $request->getParameters();'
            ],
            '}',
            ''
        ];

        foreach($instructions as $oneInstruction) {
            $newLines = $this->generateCodeLinesFromInstruction($oneInstruction);
            if (!empty($newLines)) {
                $lines = array_merge($lines, $newLines, ['']);
            }
        }

        $lastIndex = count($instructions) - 1;
        if ($instructions[$lastIndex]->hasAssignment()) {
            $variableName = $instructions[$lastIndex]->getAssignment()->getVariableName();
            $lines[] = 'return $'.$variableName.';';
        }

        return explode(PHP_EOL, $process($lines));
    }

    public function fromInstructionsToCustomMethod(array $instructions) {
        $name = 'execute';
        $sourceCodeLines = $this->getSourceCodeLines($instructions);
        $parameter = $this->parameterAdapter->fromDataToParameter([
            'name' => 'httpRequest',
            'namespace' => new ConcreteNamespace(explode('\\', 'iRESTful\Objects\Libraries\Https\Domain\Requests\HttpRequest'))
        ]);

        return new ConcreteClassMethodCustom($name, $sourceCodeLines, [$parameter]);
    }

    public function fromObjectToCustomMethods(Object $object) {

        if (!$object->hasMethods()) {
            return [];
        }

        $methods = $object->getMethods();
        return $this->fromMethodsToCustomMethods($methods);

    }

    public function fromMethodsToCustomMethods(array $methods) {
        $output = [];
        foreach($methods as $oneMethod) {
            $output[] = $this->fromMethodToCustomMethod($oneMethod);
        }

        return $output;
    }

    public function fromMethodToCustomMethod(Method $method) {
        $name = $method->getName();
        $codeMethod = $method->getMethod();
        return $this->createClassMethodCustom($name, $codeMethod);
    }

    public function fromTypeToCustomMethod(Type $type) {
        if ($type->hasMethod()) {
            return null;
        }

        $method = $type->getMethod();
        return $this->fromMethodToCustomMethod($method);
    }

    private function createClassMethodCustom($name, CodeMethod $codeMethod) {

        $removeBraces = function(array $code) {

            $fixIndentation = function(array $lines) {
                $output = [];
                $rightSize = 0;
                $size = null;
                $amountToAdd = null;
                $amountToSubstract = null;
                foreach($lines as $index => $oneLine) {

                    if (is_null($size)) {
                        $size = strlen($oneLine) - strlen(ltrim($oneLine));

                        if ($size < $rightSize) {
                            $amountToAdd = $rightSize - $size;
                        }

                        if ($size > $rightSize) {
                            $amountToSubstract = $size - $rightSize;
                        }
                    }

                    $filtered = '';
                    if (!is_null($amountToAdd)) {
                        $filtered = str_repeat(' ', $amountToAdd).$oneLine;
                    }

                    if (!is_null($amountToSubstract)) {
                        $filtered = substr($oneLine, $amountToSubstract);
                    }

                    if (!empty($filtered)) {
                        $output[$index] = $filtered;
                    }

                }

                return $output;
            };

            $codeWithBraces = implode(PHP_EOL, $code);
            $firstPos = strpos($codeWithBraces, '{');
            if ($firstPos === 0) {
                $codeWithBraces = substr($codeWithBraces, 1);
            }

            $lastPos = strrpos($codeWithBraces, '}');
            $length = strlen($codeWithBraces) - 1;
            if ($lastPos === $length) {
                $codeWithBraces = substr($codeWithBraces, 0, $length - 2);
            }

            $lines = explode(PHP_EOL, $codeWithBraces);
            return $fixIndentation(array_values(array_filter($lines)));

        };

        $getSourceCodeLines = function(\ReflectionMethod $reflectionMethod) use(&$removeBraces) {

            $fileName = $reflectionMethod->getFileName();
            $startLine = $reflectionMethod->getStartLine();
            $endLine = $reflectionMethod->getEndLine();
            $numLines = $endLine - $startLine;

            $contents = file_get_contents($fileName);
            $contentLines = explode(PHP_EOL, $contents);
            $sliced = array_slice($contentLines, $startLine, $numLines);
            return $removeBraces($sliced);
        };

        $parameterAdapter = $this->parameterAdapter;
        $getParameters = function(\ReflectionMethod $reflectionMethod) use(&$parameterAdapter) {
            $parameters = [];
            $reflectionParameters = $reflectionMethod->getParameters();
            foreach($reflectionParameters as $oneReflectionParameter) {

                $isOptional = false;
                if ($oneReflectionParameter->isOptional()) {
                    $isOptional = true;
                }

                $isArray = false;
                if ($oneReflectionParameter->isArray()) {
                    $isArray = true;
                }

                $parameters[] = $parameterAdapter->fromDataToParameter([
                    'name' => $oneReflectionParameter->getName(),
                    'is_optional' => $isOptional,
                    'is_array' => $isArray
                ]);
            }

            return $parameters;
        };

        $code = $codeMethod->getCode();
        $methodName = $codeMethod->getMethodName();
        $className = $code->getClassName();
        $reflectionMethod = new \ReflectionMethod($className, $methodName);

        $language = $code->getLanguage()->get();
        if ($language != 'PHP') {
            throw new CustomMethodException('The input language ('.$language.') is not yet supported.');
        }

        $sourceCodeLines = $getSourceCodeLines($reflectionMethod);
        $parameters = $getParameters($reflectionMethod);
        return new ConcreteClassMethodCustom($name, $sourceCodeLines, $parameters);
    }

}
