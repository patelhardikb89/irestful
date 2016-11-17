<?php
namespace  iRESTful\Rodson\Outputs\Domain\Codes\Services;
use  iRESTful\Rodson\Outputs\Domain\Codes\Code;

interface CodeService {
    public function save(Code $code);
    public function saveMultiple(array $codes);
}
