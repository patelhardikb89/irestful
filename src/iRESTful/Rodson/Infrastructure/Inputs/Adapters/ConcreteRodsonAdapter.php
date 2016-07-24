<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Adapters\RodsonAdapter;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;
use iRESTful\Rodson\Domain\Inputs\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Inputs\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteRodson;

final class ConcreteRodsonAdapter implements RodsonAdapter {
    private $objectAdapter;
    private $controllerAdapter;
    public function __construct(ObjectAdapter $objectAdapter, ControllerAdapter $controllerAdapter) {
        $this->objectAdapter = $objectAdapter;
        $this->controllerAdapter = $controllerAdapter;
    }

    public function fromDataToRodson(array $data) {

        $convert = function($name) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return ucfirst($name);

        };

        if (!isset($data['name'])) {
            throw new RodsonException('The name keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['objects'])) {
            throw new RodsonException('The objects keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['controllers'])) {
            throw new RodsonException('The controllers keyname is mandatory in order to convert data to a Rodson object.');
        }

        try {

            $parents = null;
            if (isset($data['parents'])) {
                $parents = $this->fromDataToRodsons($data['parents']);
            }

            $name = $convert($data['name']);
            $objects = $this->objectAdapter->fromDataToObjects($data['objects']);
            $controllers = $this->controllerAdapter->fromDataToControllers($data['controllers']);

            return new ConcreteRodson($name, $objects, $controllers, $parents);

        } catch (ObjectException $exception) {
            throw new RodsonException('There was an exception while converting data to Object objects.', $exception);
        } catch (ControllerException $exception) {
            throw new RodsonException('There was an exception while converting data to Controller objects.', $exception);
        }

    }

    public function fromDataToRodsons(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToRodson($oneData);
        }

        return $output;
    }

}
