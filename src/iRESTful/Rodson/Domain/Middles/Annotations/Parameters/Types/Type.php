<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Types;

interface Type {
    public function isUnique();
    public function isKey();
    public function getDatabaseType();
    public function hasDefault();
    public function getDefault();
    public function getData();
}
