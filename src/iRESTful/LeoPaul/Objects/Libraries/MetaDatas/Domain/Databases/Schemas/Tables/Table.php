<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables;

interface Table {
    public function getName();
    public function getEngine();
    public function getFields();
    public function hasPrimaryKey();
    public function getPrimaryKey();
}
