<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Services;
use iRESTful\Rodson\Domain\Outputs\Codes\Code;

interface CodeService {
    public function save(Code $code);
    public function saveMultiple(array $codes);
}
