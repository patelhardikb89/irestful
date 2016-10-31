<?php
namespace iRESTful\ClassesTests\Infrastructure\Adapters;
use iRESTful\ClassesTests\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\TestInstructions\Domain\Adapters\Adapters\TestInstructionAdapterAdapter;
use iRESTful\TestInstructions\Domain\CustomMethods\Nodes\Adapters\CustomMethodNodeAdapter;
use iRESTful\ClassesTests\Infrastructure\Objects\ConcreteTestController;
use iRESTful\ClassesTests\Domain\Controllers\Exceptions\ControllerException;
use iRESTful\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteTestControllerAdapter implements ControllerAdapter {
    private $testInstructionAdapterAdapter;
    private $customMethodNodeAdapter;
    private $baseNamespace;
    public function __construct(
        TestInstructionAdapterAdapter $testInstructionAdapterAdapter,
        CustomMethodNodeAdapter $customMethodNodeAdapter,
        array $baseNamespace
    ) {
        $this->testInstructionAdapterAdapter = $testInstructionAdapterAdapter;
        $this->customMethodNodeAdapter = $customMethodNodeAdapter;
        $this->baseNamespace = $baseNamespace;
    }

    public function fromDataToControllers(array $data) {

        if (!isset($data['controllers'])) {
            throw new ControllerException('The controllers keyname is mandatory in order to convert data to Controller objects.');
        }

        if (!isset($data['configuration'])) {
            throw new ControllerException('The configuration keyname is mandatory in order to convert data to Controller objects.');
        }

        if (!isset($data['annotated_entities'])) {
            throw new ControllerException('The annotated_entities keyname is mandatory in order to convert data to Controller objects.');
        }

        $output = [];
        foreach($data['controllers'] as $oneController) {
            $testController = $this->fromDataToController([
                'controller' => $oneController,
                'configuration' => $data['configuration'],
                'annotated_entities' => $data['annotated_entities']
            ]);

            if (!empty($testController)) {
                $output[] = $testController;
            }
        }

        return $output;
    }

    public function fromDataToController(array $data) {

        $convert = function($name) {
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return ucfirst($name);
        };

        if (!isset($data['controller'])) {
            throw new ControllerException('The controller keyname is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['configuration'])) {
            throw new ControllerException('The configuration keyname is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['annotated_entities'])) {
            throw new ControllerException('The annotated_entities keyname is mandatory in order to convert data to a Controller object.');
        }

        $testInstructions = $this->testInstructionAdapterAdapter->fromAnnotatedEntitiesToTestInstructionAdapter($data['annotated_entities'])
                                                                ->fromDSLControllerToTestInstructions($data['controller']);

        $testCustomMethodNodes = $this->customMethodNodeAdapter->fromTestInstructionsToCustomMethodNodes($testInstructions);
        if (empty($testCustomMethodNodes)) {
            return null;
        }

        $name = $convert($data['controller']->getName()).'Test';
        $merged = array_merge($this->baseNamespace, ['Tests', 'Tests', 'Functional', 'Controllers', $name]);
        $namespace = new ConcreteNamespace($merged);

        return new ConcreteTestController($namespace, $data['configuration'], $testCustomMethodNodes);

    }

}
