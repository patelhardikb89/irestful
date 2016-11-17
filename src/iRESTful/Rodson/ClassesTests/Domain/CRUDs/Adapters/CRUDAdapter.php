<?php
namespace iRESTful\Rodson\ClassesTests\Domain\CRUDs\Adapters;

interface CRUDAdapter {
    public function fromDataTOCRUDs(array $data);
}
