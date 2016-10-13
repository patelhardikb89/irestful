<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Adapters;

interface EntityAdapter {
    public function fromDataToEntity(array $data);
}
