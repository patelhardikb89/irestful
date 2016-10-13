<?php
namespace iRESTful\Annotations\Domain\Parameters\Types;

interface Type {
    public function isUnique();
    public function isKey();
    public function getDatabaseType();
    public function hasDefault();
    public function getDefault();
}
