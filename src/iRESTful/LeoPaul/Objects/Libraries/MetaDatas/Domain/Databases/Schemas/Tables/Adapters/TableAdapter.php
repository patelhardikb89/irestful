<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;

interface TableAdapter {
    public function fromDataToTable(array $data);
    public function fromDataToTables(array $data);
    public function fromClassMetaDataToTable(ClassMetaData $classMetaData);
}
