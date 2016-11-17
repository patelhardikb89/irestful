<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Codes\Adapters;

interface CodeAdapter {
    public function fromDataToCode(array $data);
}
