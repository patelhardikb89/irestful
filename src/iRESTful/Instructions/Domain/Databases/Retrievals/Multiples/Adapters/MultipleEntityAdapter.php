<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\Adapters;

interface MultipleEntityAdapter {
    public function fromDataToMultipleEntity(array $data);
}
