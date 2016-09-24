<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteConfigurationController;

final class ConcreteConfigurationControllerAdapter implements ControllerAdapter {
    private $methodMapper;
    public function __construct() {
        $this->methodMapper = [
            'retrieve' => 'get',
            'insert' => 'post',
            'update' => 'put',
            'delete' => 'delete'
        ];
    }

    public function fromDataToControllers(array $data) {

        if (!isset($data['inputs'])) {
            throw new ControllerException('The inputs keyname is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['classes'])) {
            throw new ControllerException('The classes keyname is mandatory in order to convert data to a Controller object.');
        }

        if (count($data['inputs']) != count($data['classes'])) {
            throw new ControllerException('The inputs array must contain the same amount of elements as the classes array.');
        }

        $output = [];
        foreach($data['inputs'] as $index => $oneInput) {
            $controllerPattern = $oneInput->getPattern();
            $exploded = explode(' ', $controllerPattern);

            if (!isset($exploded[0]) || !isset($exploded[1])) {
                throw new ControllerException('The controller ('.$oneInput->getName().') contains an invalid pattern ('.$controllerPattern.').');
            }

            $controllerPatternMethod = trim($exploded[0]);
            if (!isset($this->methodMapper[$controllerPatternMethod])) {
                throw new ControllerException('The controller ('.$oneInput->getName().') contains an invalid method name ('.$controllerPatternMethod.') in pattern ('.$controllerPattern.').');
            }

            $output[] = new ConcreteConfigurationController(
                trim($exploded[1]),
                $this->methodMapper[$controllerPatternMethod],
                $data['classes'][$index]
            );
        }

        return $output;

    }

}
