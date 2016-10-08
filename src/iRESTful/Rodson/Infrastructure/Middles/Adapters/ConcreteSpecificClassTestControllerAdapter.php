<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Adapters\Adapters\TestInstructionAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassTestController;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;

final class ConcreteSpecificClassTestControllerAdapter implements ControllerAdapter {
    private $testInstructionAdapterAdapter;
    private $customMethodAdapter;
    private $baseNamespace;
    public function __construct(
        TestInstructionAdapterAdapter $testInstructionAdapterAdapter,
        CustomMethodAdapter $customMethodAdapter,
        array $baseNamespace
    ) {
        $this->testInstructionAdapterAdapter = $testInstructionAdapterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->baseNamespace = $baseNamespace;
    }

    public function fromDataToControllers(array $data) {

        if (!isset($data['controllers'])) {
            throw new ControllerException('The controllers keyname is mandatory in order to convert data to Controller objects.');
        }

        if (!isset($data['annotated_entities'])) {
            throw new ControllerException('The annotated_entities keyname is mandatory in order to convert data to Controller objects.');
        }

        $output = [];
        foreach($data['controllers'] as $oneController) {
            $output[] = $this->fromDataToController([
                'controller' => $oneController,
                'annotated_entities' => $data['annotated_entities']
            ]);
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

        if (!isset($data['annotated_entities'])) {
            throw new ControllerException('The annotated_entities keyname is mandatory in order to convert data to a Controller object.');
        }

        $testInstructions = $this->testInstructionAdapterAdapter->fromAnnotatedEntitiesToTestInstructionAdapter($data['annotated_entities'])
                                                                ->fromControllerToTestInstructions($data['controller']);

        $testCustomMethods = $this->customMethodAdapter->fromTestInstructionsToCustomMethods($testInstructions);

        $name = $convert($data['controller']->getName()).'Test';
        $merged = array_merge($this->baseNamespace, ['Tests', 'Tests', 'Functional', 'Controllers', $name]);
        $namespace = new ConcreteNamespace($merged);

        return new ConcreteSpecificClassTestController($namespace, $testCustomMethods);

    }

}
