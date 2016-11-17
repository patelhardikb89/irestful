<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Adapters\ProjectAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Adapters\ObjectAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\Adapters\ControllerAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\DSLs\Domain\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\DSLs\Domain\Projects\Exceptions\ProjectException;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteProject;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Adapters\EntityAdapter;
use iRESTful\DSLs\Domain\SubDSLs\Adapters\SubDSLAdapter;

final class ConcreteProjectAdapter implements ProjectAdapter {
    private $objectAdapter;
    private $entityAdapter;
    private $controllerAdapter;
    private $subDSLAdapter;
    public function __construct(
        ObjectAdapter $objectAdapter,
        EntityAdapter $entityAdapter,
        ControllerAdapter $controllerAdapter,
        SubDSLAdapter $subDSLAdapter
    ) {
        $this->objectAdapter = $objectAdapter;
        $this->entityAdapter = $entityAdapter;
        $this->controllerAdapter = $controllerAdapter;
        $this->subDSLAdapter = $subDSLAdapter;
    }

    public function fromDataToProject(array $data) {

        try {

            $parents = null;
            if (isset($data['parents'])) {
                $parents = $this->subDSLAdapter->fromDataToSubDSLs($data['parents']);
            }

            $controllers = null;
            if (isset($data['controllers'])) {
                $controllers = $this->controllerAdapter->fromDataToControllers($data['controllers']);
            }

            $objects = null;
            $entities = null;
            if (isset($data['objects'])) {

                if (!empty($parents)) {

                    $parentSamples = [];
                    foreach($parents as $oneParent) {
                        $project = $oneParent->getDSL()->getProject();
                        if ($project->hasEntities()) {
                            $entities = $project->getEntities();
                            foreach($entities as $oneEntity) {
                                $parentSamples[] = $oneEntity->getSample();
                            }
                        }
                    }

                }

                $objects = $this->objectAdapter->fromDataToObjects($data['objects']);
                $entities = $this->entityAdapter->fromDataToEntities([
                    'objects' => $objects,
                    'samples' => isset($data['samples']) ? $data['samples'] : []
                ]);
            }

            return new ConcreteProject($objects, $entities, $controllers, $parents);

        } catch (ObjectException $exception) {
            throw new ProjectException('There was an exception while converting data to Object objects.', $exception);
        } catch (ControllerException $exception) {
            throw new ProjectException('There was an exception while converting data to Controller objects.', $exception);
        }
    }

}
