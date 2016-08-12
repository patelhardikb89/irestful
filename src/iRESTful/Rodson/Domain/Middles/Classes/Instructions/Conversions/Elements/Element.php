<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements;

interface Element {
    public function isData();
    public function hasClass();
    public function getClass();
    public function hasAssignment();
    public function getAssignment();
}
