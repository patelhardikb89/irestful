<?php
namespace iRESTful\Rodson\Domain\Inputs\Codes\Adapters;

interface CodeAdapter {
    public function fromDataToCode(array $data);
}
