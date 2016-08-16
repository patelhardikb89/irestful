<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters;

interface MultipleEntityAdapter {
    public function fromDataToMultipleEntity(array $data);
}
