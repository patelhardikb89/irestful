<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To;

interface To {
    public function isData();
    public function isMultiple();
    public function hasAnnotatedClass();
    public function getAnnotatedClass();
    public function getData();
}
