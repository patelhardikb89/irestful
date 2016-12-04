<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesTests\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Objects\ConcreteTestController;
use iRESTful\Rodson\ClassesTests\Domain\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteTestControllerAdapter implements ControllerAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromDataToControllers(array $data) {

        if (!isset($data['controllers'])) {
            throw new ControllerException('The controllers keyname is mandatory in order to convert data to Controller objects.');
        }

        if (!isset($data['configuration'])) {
            throw new ControllerException('The configuration keyname is mandatory in order to convert data to Controller objects.');
        }

        $output = [];
        foreach($data['controllers'] as $oneController) {
            $testController = $this->fromDataToController([
                'controller' => $oneController,
                'configuration' => $data['configuration']
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

        $name = $convert($data['controller']->getName()).'Test';
        $merged = array_merge($this->baseNamespace, ['Tests', 'Tests', 'Functional', 'Controllers', $name]);
        $namespace = new ConcreteNamespace($merged);

        return new ConcreteTestController($namespace, $data['configuration']);

    }

}
