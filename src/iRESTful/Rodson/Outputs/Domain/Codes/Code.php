<?php
namespace  iRESTful\Rodson\Outputs\Domain\Codes;

interface Code {
    public function getCode();
    public function getPath();
    public function hasSubCodes();
    public function getSubCodes();
}
