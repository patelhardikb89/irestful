<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties;

interface Property {
    public function getName();
    public function getType();
    public function isOptional();
    public function isUnique();
    public function isKey();
    public function hasDefault();
    public function getDefault();
}
