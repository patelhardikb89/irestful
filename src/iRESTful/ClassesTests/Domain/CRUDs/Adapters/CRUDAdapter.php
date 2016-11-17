<?php
namespace iRESTful\ClassesTests\Domain\CRUDs\Adapters;

interface CRUDAdapter {
    public function fromDataTOCRUDs(array $data);
}
