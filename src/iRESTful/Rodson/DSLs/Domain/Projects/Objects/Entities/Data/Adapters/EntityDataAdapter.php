<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\Adapters;

interface EntityDataAdapter {
    public function fromDataToEntityDatas(array $data);
}
