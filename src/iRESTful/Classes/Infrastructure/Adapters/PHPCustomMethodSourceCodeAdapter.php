<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\CustomMethods\SourceCodes\Adapters\SourceCodeAdapter;
use iRESTful\Classes\Infrastructure\Objects\ConcreteCustomMethodSourceCode;
use iRESTful\Instructions\Domain\Instruction;
use iRESTful\Instructions\Domain\Assignments\Assignment;
use iRESTful\Instructions\Domain\Databases\Actions\Action;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;
use iRESTful\Instructions\Domain\Databases\Actions\Inserts\Insert;
use iRESTful\Instructions\Domain\Databases\Actions\Deletes\Delete;
use iRESTful\Instructions\Domain\Databases\Actions\Updates\Update;
use iRESTful\Instructions\Domain\Databases\Database;
use iRESTful\Instructions\Domain\Conversions\Conversion;
use iRESTful\Instructions\Domain\Databases\Retrievals\Retrieval;
use iRESTful\Instructions\Domain\Values\Value as InstructionValue;
use iRESTful\DSLs\Domain\Projects\Values\Value;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Action as HttpRequestAction;
use iRESTful\Instructions\Domain\Containers\Container;
use iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\MultipleEntity;
use iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Entity;

final class PHPCustomMethodSourceCodeAdapter implements SourceCodeAdapter {

    public function __construct() {

    }

    public function fromInstructionsToControllerSourceCode(array $instructions) {
        $inputLines = [
            '$input = [];',
            'if ($request->hasParameters()) {',
            [
                '$input = $request->getParameters();'
            ],
            '}',
            ''
        ];

        $codeLines = $this->fromInstructionsToSourceCode($instructions)->getLines();
        $totalLines = array_merge($inputLines, $codeLines);
        return $this->fromSourceCodeLinesToSourceCode($totalLines);
    }

    public function fromInstructionsToSourceCode(array $instructions) {
        $lines = [];
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

        return $this->fromSourceCodeLinesToSourceCode($lines);
    }

    public function fromDataToSourceCode(array $data) {

        if (!isset($data['instructions'])) {
            //throws
        }

        $inputLines = [];
        if (isset($data['input']) && isset($data['input']['variable']) && isset($data['input']['data'])) {
            $inputLines = [
                $data['input']['variable'].' = [',
                $this->generateHashMapCode($data['input']['data']),
                '];',
                ''
            ];
        }

        if (empty($inputLines)) {
            return $this->fromInstructionsToSourceCode($data['instructions']);
        }

        $codeLines = $this->fromInstructionsToSourceCode($data['instructions'])->getLines();
        $totalLines = array_merge($inputLines, $codeLines);
        return $this->fromSourceCodeLinesToSourceCode($totalLines);
    }

    public function fromSourceCodeLinesToSourceCode(array $lines) {
        return new ConcreteCustomMethodSourceCode($lines);
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

        if ($from->isInput()) {

            $input = '$input';
            if ($to->isMultiple()) {
                return '$this->entityAdapterFactory->create()->fromDataToEntities('.$input.');';
            }

            if ($to->isPartialSet()) {
                return '$this->entityAdapterFactory->create()->fromDataToEntityPartialSet('.$input.');';
            }

            return '$this->entityAdapterFactory->create()->fromDataToEntity('.$input.');';
        }

        //throws
    }

    private function generateArrayCode(array $params = null) {
        if (empty($params)) {
            return '[]';
        }

        $data = [];
        foreach($params as $keyname => $value) {
            $data[$keyname] = (is_string($value)) ? '$'.$value : $this->getCodeFromInstructionValue($value);
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

    private function getCodeFromInstructionValue(InstructionValue $value) {

        $getKeynameVariable = function(array $keynames) {
            $output = '';
            $hasLength = false;
            foreach($keynames as $oneKeyname) {

                $name = $oneKeyname->getName();
                if ($oneKeyname->hasMetaData()) {

                    $metaData = $oneKeyname->getMetaData();
                    if ($metaData->hasProperty()) {
                        print_r([$metaData, 'metaData', 'getCodeFromInstructionValue']);
                        die();
                    }

                    $hasLength = true;
                }


                $output .= '[\''.$name.'\']';
            }

            if ($hasLength) {
                return 'count($input'.$output.')';
            }

            return 'isset($input'.$output.') ? $input'.$output.' : null';

        };

        if ($value->hasValue()) {
            $valueValue = $value->getValue();
            return $this->getCodeFromValue($valueValue);
        }

        if ($value->hasLoop()) {
            $loop = $value->getLoop();
            if ($loop->hasKeynames()) {
                $keynames = $loop->getKeynames();
                return $getKeynameVariable($keynames);
            }

            print_r([$loop, 'getCodeFromInstructionValue']);
            die();


        }

        //throws

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

    private function getContainerNameFromContainer(Container $container) {

        if ($container->hasAnnotatedEntity()) {
            $annotatedEntity = $container->getAnnotatedEntity();
            $containerName = $annotatedEntity->getAnnotation()->getContainerName();
            return "'".$containerName."'";
        }

        if ($container->isLoopContainer()) {
            return '$containerName';
        }

        $value = $container->getValue();
        return $this->getCodeFromInstructionValue($value);
    }

    private function generateCodeLinesFromEntity(Entity $entity) {

        $container = $entity->getContainer();
        $containerName = $this->getContainerNameFromContainer($container);


        if ($entity->hasUuidValue()) {
            $uuidValue = $entity->getUuidValue();
            $uuidCode = $this->getCodeFromInstructionValue($uuidValue);

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
                    "'container' => ".$containerName,
                    "'keyname' => [",
                    [
                        "'name' => ".$this->getCodeFromInstructionValue($name),
                        "'value' => ".$this->getCodeFromInstructionValue($value)
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
                    "'uuids' => ".$this->getCodeFromInstructionValue($uuidValue)
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
                        "'name' => ".$this->getCodeFromInstructionValue($name),
                        "'value' => ".$this->getCodeFromInstructionValue($value)
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
                '\'index\' => '.$this->getCodeFromInstructionValue($index).',',
                '\'amount\' => '.$this->getCodeFromInstructionValue($amount).','
            ],
            ']);'
        ];
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

    private function generateHashMapCode(array $data) {

        $getKeyname = function($part) {
            if (is_numeric($part)) {
                return '';
            }

            return "'".$part."' => ";
        };

        $getValue = function($part) {
            if (is_numeric($part) || is_bool($part)) {
                return $part;
            }

            return "'".$part."'";
        };

        $output = [];
        $amount = count($data);
        $keys = array_keys($data);
        for($i = 0; $i < $amount; $i++) {

            $delimiter = (($i + 1) >= $amount) ? '' : ',';

            if (is_array($data[$keys[$i]])) {
                $output[] = $getKeyname($keys[$i]).'[';
                $output[] = $this->generateHashMapCode($data[$keys[$i]]);
                $output[] = ']'.$delimiter;
                continue;
            }

            $output[] = $getKeyname($keys[$i]).$getValue($data[$keys[$i]]).$delimiter;
        }

        return $output;
    }

}
