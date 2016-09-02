<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To;

interface To {
    public function isData();
    public function isMultiple();
    public function isPartialSet();
    public function hasContainer();
    public function getContainer();
    public function getData();
}
