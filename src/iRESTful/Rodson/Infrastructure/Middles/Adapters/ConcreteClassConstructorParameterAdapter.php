<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Adapters\ParameterAdapter as ConstructorParameterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassConstructorParameter;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Instruction;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Exceptions\ParameterException;

final class ConcreteClassConstructorParameterAdapter implements ConstructorParameterAdapter {
    private $namespaceAdapter;
    private $propertyAdapter;
    private $parameterAdapter;
    private $methodAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        PropertyAdapter $propertyAdapter,
        ParameterAdapter $parameterAdapter,
        MethodAdapter $methodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->propertyAdapter = $propertyAdapter;
        $this->parameterAdapter = $parameterAdapter;
        $this->methodAdapter = $methodAdapter;
    }

    public function fromInstructionsToParameters(array $instructions) {

        $parameters = [];
        foreach($instructions as $oneInstruction) {
            $newParameters = $this->fromInstructionToParameters($oneInstruction);
            if (!empty($newParameters)) {
                $parameters = array_merge($parameters, $newParameters);
            }
        }

        return $parameters;

    }

    public function fromInstructionToParameters(Instruction $instruction) {

        $parameters = [];
        if ($instruction->hasAssignment()) {
            $assignment = $instruction->getAssignment();
            $newParameters = $this->fromInstructionAssignmentToParameters($assignment);
            if (!empty($newParameters)) {
                $parameters = array_merge($parameters, $newParameters);
            }
        }

        if ($instruction->hasMergeAssignments()) {
            $assignments = $instruction->getMergeAssignments();
            $newParameters = $this->fromInstructionAssignmentsToParameters($assignments);
            if (!empty($newParameters)) {
                $parameters = array_merge($parameters, $newParameters);
            }
        }

        if ($instruction->hasAction()) {
            $action = $instruction->getAction();
            $oneParameter = $this->fromInstructionDatabaseActionToParameter($action);
            $parameters[$oneParameter->getProperty()->getName()] = $oneParameter;
        }

        return $parameters;

    }

    public function fromInstructionAssignmentsToParameters(array $assignments) {
        $parameters = [];
        foreach($assignments as $oneAssignment) {
            $newParameters = $this->fromInstructionAssignmentToParameters($oneAssignment);
            if (!empty($newParameters)) {
                $parameters = array_merge($parameters, $newParameters);
            }
        }

        return $parameters;
    }

    public function fromInstructionAssignmentToParameters($assignment) {

        $parameters = [];
        if ($assignment->hasMergedAssignments()) {
            $assignments = $assignment->getMergedAssignments();
            $newParameters = $this->fromInstructionAssignmentsToParameters($assignments);
            if (!empty($newParameters)) {
                $parameters = array_merge($parameters, $newParameters);
            }
        }

        if ($assignment->hasConversion()) {
            $conversion = $assignment->getConversion();

            $propertyName = 'entityAdapterFactory';
            $namespace = $this->namespaceAdapter->fromConversionToNamespace($conversion);
            $property = $this->propertyAdapter->fromNameToProperty($propertyName);
            $methodParameter = $this->parameterAdapter->fromDataToParameter([
                'name' => $propertyName,
                'namespace' => $namespace
            ]);

            $parameters[$propertyName] = new ConcreteClassConstructorParameter($property, $methodParameter);

            $from = $conversion->from();
            if ($from->hasAssignment()) {
                $assignment = $from->getAssignment();
                $newParameters = $this->fromInstructionAssignmentToParameters($assignment);
                if (!empty($newParameters)) {
                    $parameters = array_merge($parameters, $newParameters);
                }
            }
        }

        if ($assignment->hasDatabase()) {
            $database = $assignment->getDatabase();

            if ($database->hasRetrieval()) {
                $retrieval = $database->getRetrieval();
                $newParameter = $this->fromInstructionDatabaseRetrievalToParameter($retrieval);
                $parameters[$newParameter->getProperty()->getName()] = $newParameter;
            }

            if ($database->hasAction()) {
                $action = $database->getAction();
                $newParameter = $this->fromInstructionDatabaseActionToParameter($action);
                $parameters[$newParameter->getProperty()->getName()] = $newParameter;
            }
        }

        return $parameters;
    }

    public function fromInstructionDatabaseActionToParameter($action) {

        $getPropertyName = function($action) {
            if ($action->hasHttpRequest()) {
                return 'httpApplicationFactoryAdapter';
            }

            return 'entityServiceFactory';
        };

        $propertyName = $getPropertyName($action);

        $namespace = $this->namespaceAdapter->fromActionToNamespace($action);
        $property = $this->propertyAdapter->fromNameToProperty($propertyName);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $propertyName,
            'namespace' => $namespace
        ]);

        return new ConcreteClassConstructorParameter($property, $methodParameter);
    }

    public function fromInstructionDatabaseRetrievalToParameter($retrieval) {

        $getPropertyName = function($retrieval) {
            if ($retrieval->hasHttpRequest()) {
                return 'httpApplicationFactoryAdapter';
            }

            if ($retrieval->hasEntity()) {
                return 'entityRepositoryFactory';
            }

            if ($retrieval->hasMultipleEntities()) {
                return 'entitySetRepositoryFactory';
            }

            if ($retrieval->hasEntityPartialSet()) {
                return 'entityPartialSetRepositoryFactory';
            }

            throw new ParameterException('The given retrieval object did not have a valid retrieval method.');
        };

        $propertyName = $getPropertyName($retrieval);

        $namespace = $this->namespaceAdapter->fromRetrievalToNamespace($retrieval);
        $property = $this->propertyAdapter->fromNameToProperty($propertyName);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $propertyName,
            'namespace' => $namespace
        ]);

        return new ConcreteClassConstructorParameter($property, $methodParameter);
    }

    public function fromObjectToParameters(Object $object) {
        $output = [];
        $properties = $object->getProperties();
        foreach($properties as $oneProperty) {
            $output[] = $this->fromPropertyToParameter($oneProperty);
        }

        return $output;
    }

    public function fromPropertyToParameter(Property $property) {

        $propertyName = $property->getName();
        $propertyIsOptional = $property->isOptional();
        $propertyType = $property->getType();
        $method = $this->methodAdapter->fromPropertyToMethod($property);
        $classProperty = $this->propertyAdapter->fromNameToProperty($propertyName);

        if ($propertyType->hasPrimitive()) {
            $propertyTypePrimitive = $propertyType->getPrimitive();
            $methodParameter = $this->parameterAdapter->fromDataToParameter([
                'name' => $propertyName,
                'primitive' => $propertyTypePrimitive->getName(),
                'is_optional' => $propertyIsOptional
            ]);

            return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
        }

        $propertyIsArray = $propertyType->isArray();
        $namespace = $this->namespaceAdapter->fromPropertyTypeToNamespace($propertyType);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $propertyName,
            'namespace' => $namespace,
            'is_optional' => $propertyIsOptional,
            'is_array' => $propertyIsArray
        ]);

        return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
    }

    public function fromTypeToParameter(Type $type) {
        $name = $type->getName();
        $classProperty = $this->propertyAdapter->fromNameToProperty($name);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $name
        ]);

        $method = $this->methodAdapter->fromTypeToMethod($type);
        return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
    }

}
