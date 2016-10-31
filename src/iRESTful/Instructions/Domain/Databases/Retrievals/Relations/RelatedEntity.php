<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Relations;

interface RelatedEntity {
    public function getMasterContainer();
    public function getMasterUuidValue();
    public function getSlavePropertyValue();
    public function getSlaveContainer();
}
