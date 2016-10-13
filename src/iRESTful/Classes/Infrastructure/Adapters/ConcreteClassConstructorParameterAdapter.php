<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Constructors\Parameters\Adapters\ParameterAdapter as ConstructorParameterAdapter;
use iRESTful\Classes\Domain\Properties\Adapters\PropertyAdapter;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Classes\Infrastructure\Objects\ConcreteClassConstructorParameter;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\Classes\Domain\Constructors\Parameters\Methods\Adapters\MethodAdapter;
use iRESTful\Instructions\Domain\Instruction;
use iRESTful\Classes\Domain\Constructors\Parameters\Exceptions\ParameterException;

final class ConcreteClassConstructorParameterAdapter implements ConstructorParameterAdapter {
    private $namespaceAdapter;
    private $propertyAdapter;
    private $parameterAdapter;
    private $methodAdapter;
    public function __construct(
        InterfaceNamespaceAdapter $namespaceAdapter,
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
            $namespaceData = explode('\\', 'iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');

            $namespace = $this->namespaceAdapter->fromDataToNamespace($namespaceData);
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

        $getNamespaceData = function($action) {
            if ($action->hasHttpRequest()) {
                return explode('\\', 'iRESTful\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter');
            }

            if ($action->hasInsert() || $action->hasUpdate() || $action->hasDelete()) {
                return explode('\\', 'iRESTful\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory');
            }

            //throws
        };

        $propertyName = $getPropertyName($action);
        $namespaceData = $getNamespaceData($action);

        $namespace = $this->namespaceAdapter->fromDataToNamespace($namespaceData);
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

        $getNamespaceData = function($retrieval) {

            $name = '';
            if ($retrieval->hasHttpRequest()) {
                $name = 'iRESTful\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter';
            }

            if ($retrieval->hasEntity()) {
                $name = 'iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory';
            }

            if ($retrieval->hasMultipleEntities()) {
                $name = 'iRESTful\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory';
            }

            if ($retrieval->hasEntityPartialSet()) {
                $name = 'iRESTful\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory';
            }

            if (empty($name)) {
                throw new NamespaceException('The given Retrieval object did not have a valid retrieval method.');
            }

            return explode('\\', $name);
        };

        $propertyName = $getPropertyName($retrieval);
        $namespaceData = $getNamespaceData($retrieval);

        $namespace = $this->namespaceAdapter->fromDataToNamespace($namespaceData);
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

        $getNamespace = function($propertyType) {
            if ($propertyType->hasType()) {
                $type = $propertyType->getType();
                return $this->namespaceAdapter->fromTypeToNamespace($type);
            }

            if ($propertyType->hasObject()) {
                $object = $propertyType->getObject();
                return $this->namespaceAdapter->fromObjectToNamespace($object);
            }

            //throws
        };

        $propertyName = $property->getName();
        $propertyIsOptional = $property->isOptional();
        $propertyType = $property->getType();
        $method = $this->methodAdapter->fromPropertyToMethod($property);
        $classProperty = $this->propertyAdapter->fromNameToProperty($propertyName);

        if ($propertyType->hasPrimitive()) {
            $propertyTypePrimitive = $propertyType->getPrimitive();
            $methodParameter = $this->parameterAdapter->fromDataToParameter([
                'name' => $propertyName,
                'primitive' => $propertyTypePrimitive,
                'is_optional' => $propertyIsOptional
            ]);

            return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
        }

        $propertyIsArray = $propertyType->isArray();
        $namespace = $getNamespace($propertyType);
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
