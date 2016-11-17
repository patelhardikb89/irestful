<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ConcreteObjectAdapter implements ObjectAdapter {
    private $keynameClasses;
    private $keynameRelationData;
    private $data;
    private $returnedObject;
    private $returnedSubObjects;
    private $returnedRelationObjects;
    private $returnedRelationObjectsList;
    private $throwsException;
    private $executesInvalidCallback;
    public function __construct(array $keynameClasses, array $keynameRelationData, array $data, $returnedObject, array $returnedSubObjects, array $returnedRelationObjects, array $returnedRelationObjectsList, $throwsException, $executesInvalidCallback) {
        $this->keynameClasses = $keynameClasses;
        $this->keynameRelationData = $keynameRelationData;
        $this->data = $data;
        $this->returnedObject = $returnedObject;
        $this->returnedSubObjects = $returnedSubObjects;
        $this->returnedRelationObjects = $returnedRelationObjects;
        $this->returnedRelationObjectsList = $returnedRelationObjectsList;
        $this->throwsException = $throwsException;
        $this->executesInvalidCallback = $executesInvalidCallback;
    }

    public function fromObjectToData($object, $isHumanReadable) {

        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return $this->data;
    }

	public function fromObjectsToData(array $objects, $isHumanReadable) {

        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return [$this->data];
    }

	public function fromDataToObject(array $data) {

        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        if ($this->executesInvalidCallback) {
            $data['callback_on_fail']([]);
        }

        try {

            $input = $data['data'];
            foreach($this->keynameClasses as $keyname => $className) {

                if (isset($input[$keyname]) && is_array($input[$keyname])) {
                    foreach($input[$keyname] as $index => $oneElement) {
                        $input[$keyname][$index] = $data['callback_on_fail']([
                            'class' => $className,
                            'input' => $input[$keyname][$index]
                        ]);
                    }

                }

            }

            foreach($this->keynameRelationData as $keyname => $oneRelationData) {

                if (array_key_exists($keyname, $input) && is_null($input[$keyname])) {
                    $input[$keyname] = $data['callback_on_fail']([
                        'master_container' => $oneRelationData['master_container'],
                        'slave_type' => $oneRelationData['slave_type'],
                        'slave_property' => $oneRelationData['slave_property'],
                        'master_uuid' => $input['uuid']
                    ]);
                }

            }

            return $this->returnedObject;

        } catch (ClassMetaDataException $exception) {
            throw new ObjectException('TEST', $exception);
        }
    }

	public function fromDataToObjects(array $data) {

        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return [$this->returnedObject];
    }

    public function fromObjectToSubObjects($object) {
        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return $this->returnedSubObjects;
    }

    public function fromObjectsToSubObjects(array $objects) {
        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return $this->returnedSubObjects;
    }

    public function fromObjectToRelationObjects($object) {

        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return $this->returnedRelationObjects;

    }

    public function fromObjectsToRelationObjectsList(array $objects) {

        if ($this->throwsException) {
            throw new ObjectException('TEST');
        }

        return $this->returnedRelationObjectsList;

    }

    public function fromObjectToEmptyRelationObjectKeynames($object) {
        
    }

}
