<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters;

interface EntityRepositoryServiceAdapter {
    public function fromClassNameToObject($className);
}
