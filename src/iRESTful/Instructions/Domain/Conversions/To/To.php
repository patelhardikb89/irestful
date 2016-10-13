<?php
namespace iRESTful\Instructions\Domain\Conversions\To;

interface To {
    public function isData();
    public function isMultiple();
    public function isPartialSet();
    public function hasContainer();
    public function getContainer();
}
