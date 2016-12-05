<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\DSLs\Domain\Projects\Exceptions\ProjectException;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteProject;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\DSLs\Domain\SubDSLs\Adapters\SubDSLAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Code;

final class ConcreteProjectAdapter implements ProjectAdapter {
    private $code;
    private $objectAdapter;
    private $entityAdapter;
    private $controllerAdapter;
    private $subDSLAdapter;
    public function __construct(
        Code $code,
        ObjectAdapter $objectAdapter,
        EntityAdapter $entityAdapter,
        ControllerAdapter $controllerAdapter,
        SubDSLAdapter $subDSLAdapter
    ) {
        $this->code = $code;
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

            $staticData = null;
            if (isset($data['data'])) {
                $staticData = $data['data'];
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
                    'samples' => isset($data['samples']) ? $data['samples'] : [],
                    'data' => $staticData
                ]);
            }
            
            return new ConcreteProject($this->code, $objects, $entities, $controllers, $parents);

        } catch (ObjectException $exception) {
            throw new ProjectException('There was an exception while converting data to Object objects.', $exception);
        } catch (ControllerException $exception) {
            throw new ProjectException('There was an exception while converting data to Controller objects.', $exception);
        }
    }

}
