<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys;

interface ForeignKey {
    public function hasTableReference();
    public function getTableReference();
    public function hasMultiTableReference();
    public function getMultiTableReference();
}
