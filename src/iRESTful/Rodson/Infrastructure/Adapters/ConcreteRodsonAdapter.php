<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Adapters\RodsonAdapter;
use iRESTful\Rodson\Domain\Exceptions\RodsonException;
use iRESTful\Rodson\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Controllers\Exceptions\ControllerException;

final class ConcreteRodsonAdapter implements RodsonAdapter {
    private $objectAdapter;
    private $controllerAdapter;
    public function __construct(ObjectAdapter $objectAdapter, ControllerAdapter $controllerAdapter) {
        $this->objectAdapter = $objectAdapter;
        $this->controllerAdapter = $controllerAdapter;
    }

    public function fromJsonStringToRodson($json) {

        if (empty($json)) {
            throw new RodsonException('The json cannot be empty.');
        }

        $data = @json_decode($json, true);
        if (empty($data)) {
            throw new RodsonException('The given json is invalid.');
        }

        return $this->fromDataToRodson($data);

    }

    public function fromDataToRodson(array $data) {

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
            if (isset($data['parents'])){
                $parents = $this->fromDataToRodsons($data['parents']);
            }

            $objects = $this->objectAdapter->fromDataToObjects($data['objects']);
            $controllers = $this->controllerAdapter->fromDataToControllers($data['controllers']);

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
