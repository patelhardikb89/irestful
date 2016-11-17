<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields;

interface Field {
    public function getName();
    public function getType();
    public function isPrimaryKey();
    public function isUnique();
    public function isNullable();
    public function hasDefault();
    public function getDefault();
    public function hasForeignKey();
    public function getForeignKey();
    public function isRecursive();
}
