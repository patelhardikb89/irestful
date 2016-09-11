<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Adapters\SpecificClassAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Adapters\Adapters\ControllerAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClass;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Adapters\TestAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\Adapters\AnnotatedEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\Adapters\AnnotatedObjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;

final class ConcreteSpecificClassAdapter implements SpecificClassAdapter {
    private $annotatedEntityAdapter;
    private $annotatedObjectAdapter;
    private $controllerAdapterAdapter;
    private $valueAdapter;
    private $testAdapter;
    public function __construct(
        AnnotatedEntityAdapter $annotatedEntityAdapter,
        AnnotatedObjectAdapter $annotatedObjectAdapter,
        ValueAdapter $valueAdapter,
        TestAdapter $testAdapter,
        ControllerAdapterAdapter $controllerAdapterAdapter
    ) {
        $this->annotatedEntityAdapter = $annotatedEntityAdapter;
        $this->annotatedObjectAdapter = $annotatedObjectAdapter;
        $this->valueAdapter = $valueAdapter;
        $this->testAdapter = $testAdapter;
        $this->controllerAdapterAdapter = $controllerAdapterAdapter;
    }

    public function fromRodsonToClasses(Rodson $rodson) {

        $getTypes = function(array $objects) {
            $output = [];
            foreach($objects as $oneObject) {
                $objectTypes = $oneObject->getTypes();
                foreach($objectTypes as $oneObjectType) {
                    $name = $oneObjectType->getName();
                    $output[$name] = $oneObjectType;
                }
            }

            return array_values($output);
        };

        $output = [];

        $objects = $rodson->getObjects();
        $controllers = $rodson->getControllers();
        $types = $getTypes($objects);

        $annotatedObjects = $this->annotatedObjectAdapter->fromObjectsToAnnotatedObjects($objects);
        $annotatedEntities = $this->annotatedEntityAdapter->fromObjectsToAnnotatedEntities($objects);
        $values = $this->valueAdapter->fromTypesToValues($types);
        $tests = $this->testAdapter->fromDataToTests([
            'annotated_entities' => $annotatedEntities,
            'annotated_objects' => $annotatedObjects,
            'values' => $values
        ]);


        $specificControllers = $this->controllerAdapterAdapter->fromAnnotatedEntitiesToControllerAdapter($annotatedEntities)
                                                                ->fromControllersToSpecificControllers($controllers);

        foreach($annotatedObjects as $oneAnnotatedObject) {
            $output[] = new ConcreteSpecificClass($oneAnnotatedObject);
        }

        foreach($annotatedEntities as $oneAnnotatedEntity) {
            $output[] = new ConcreteSpecificClass(null, $oneAnnotatedEntity);
        }

        foreach($values as $oneValue) {
            $output[] = new ConcreteSpecificClass(null, null, $oneValue);
        }

        foreach($specificControllers as $oneController) {
            $output[] = new ConcreteSpecificClass(null, null, null, $oneController);
        }

        foreach($tests as $oneTest) {
            $output[] = new ConcreteSpecificClass(null, null, null, null, $oneTest);
        }

        return $output;
    }

}
