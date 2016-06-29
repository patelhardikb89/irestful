<?php
namespace iRESTful\Rodson\Domain\Codes\Adapters;

interface CodeAdapter {
    public function fromDataToCode(array $data);
}
