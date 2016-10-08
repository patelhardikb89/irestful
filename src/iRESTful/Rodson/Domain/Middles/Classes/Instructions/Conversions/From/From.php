<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From;

interface From {
    public function isData();
    public function isInput();
    public function hasInputKeynames();
    public function getInputKeynames();
    public function hasAssignment();
    public function getAssignment();
    public function getData();
}
