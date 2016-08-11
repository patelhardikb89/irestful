<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Conversions\Elements;

interface Element {
    public function isData();
    public function hasObject();
    public function getObject();
    public function hasAssignment();
    public function getAssignment();
}
