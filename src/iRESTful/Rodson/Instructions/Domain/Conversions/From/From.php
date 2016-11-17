<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\From;

interface From {
    public function isData();
    public function isInput();
    public function hasInputKeynames();
    public function getInputKeynames();
    public function hasAssignment();
    public function getAssignment();
}
