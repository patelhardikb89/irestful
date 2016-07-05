<?php
namespace iRESTful\Rodson\Infrastructure\Services;
use iRESTful\Rodson\Domain\Inputs\Objects\Services\ObjectService;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Services\InterfaceService;

final class FileObjectService implements ObjectService {
    private $interfaceAdapter;
    private $interfaceService;
    public function __construct(InterfaceAdapter $interfaceAdapter, InterfaceService $interfaceService) {
        $this->interfaceAdapter = $interfaceAdapter;
        $this->interfaceService = $interfaceService;
    }

    public function save(Object $object) {

        //interfaces:
        $interface = $this->interfaceAdapter->fromObjectToInterface($object);
        $this->interfaceService->save($interface);

        //classes:

    }

    public function saveMultiple(array $objects) {

    }

}
