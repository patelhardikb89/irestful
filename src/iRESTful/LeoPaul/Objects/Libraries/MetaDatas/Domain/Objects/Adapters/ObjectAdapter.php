<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters;

interface ObjectAdapter {
	public function fromObjectToData($object, $isHumanReadable);
	public function fromObjectsToData(array $objects, $isHumanReadable);
	public function fromDataToObject(array $data);
	public function fromDataToObjects(array $data);
    public function fromObjectToSubObjects($object);
    public function fromObjectsToSubObjects(array $objects);
    public function fromObjectToRelationObjects($object);
    public function fromObjectsToRelationObjectsList(array $objects);
    public function fromObjectToEmptyRelationObjectKeynames($object);
}
