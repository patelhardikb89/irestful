<?php
namespace iRESTful\DSLs\Domain\Projects\Codes\Adapters;

interface CodeAdapter {
    public function fromDataToCode(array $data);
}
