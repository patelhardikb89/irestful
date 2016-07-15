<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes;

interface Code {
    public function getCode();
    public function getPath();
    public function hasSubCodes();
    public function getSubCodes();
}
