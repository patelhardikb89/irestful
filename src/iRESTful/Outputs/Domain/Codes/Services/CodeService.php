<?php
namespace  iRESTful\Outputs\Domain\Codes\Services;
use  iRESTful\Outputs\Domain\Codes\Code;

interface CodeService {
    public function save(Code $code);
    public function saveMultiple(array $codes);
}
