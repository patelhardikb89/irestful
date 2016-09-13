<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Domain\Inputs\Projects\Exceptions\ProjectException;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteProject;

final class ConcreteProjectAdapter implements ProjectAdapter {
    private $objectAdapter;
    private $controllerAdapter;
    public function __construct(ObjectAdapter $objectAdapter, ControllerAdapter $controllerAdapter) {
        $this->objectAdapter = $objectAdapter;
        $this->controllerAdapter = $controllerAdapter;
    }

    public function fromDataToProject(array $data) {

        if (!isset($data['objects'])) {
            throw new ProjectException('The objects keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['controllers'])) {
            throw new ProjectException('The controllers keyname is mandatory in order to convert data to a Project object.');
        }

        try {

            $parents = null;
            if (isset($data['parents'])) {
                $parents = $this->fromDataToProjects($data['parents']);
            }

            $objects = $this->objectAdapter->fromDataToObjects($data['objects']);
            $controllers = $this->controllerAdapter->fromDataToControllers($data['controllers']);

            return new ConcreteProject($objects, $controllers, $parents);

        } catch (ObjectException $exception) {
            throw new ProjectException('There was an exception while converting data to Object objects.', $exception);
        } catch (ControllerException $exception) {
            throw new ProjectException('There was an exception while converting data to Controller objects.', $exception);
        }
    }

    public function fromDataToProjects(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToProject($oneData);
        }

        return $output;
    }

}
