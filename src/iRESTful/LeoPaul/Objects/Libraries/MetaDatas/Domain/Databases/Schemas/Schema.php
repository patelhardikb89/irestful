<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas;

interface Schema {
    public function getName();
    public function hasTables();
    public function getTables();
}
