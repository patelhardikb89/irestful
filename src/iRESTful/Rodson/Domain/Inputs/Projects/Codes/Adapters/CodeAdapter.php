<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Codes\Adapters;

interface CodeAdapter {
    public function fromDataToCode(array $data);
}
