<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Adapters;

interface ComboAdapter {
    public function fromDataToCombos(array $data);
}
