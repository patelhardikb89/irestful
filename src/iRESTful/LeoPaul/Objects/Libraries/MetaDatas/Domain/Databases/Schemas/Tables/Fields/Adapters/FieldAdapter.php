<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Adapters;

interface FieldAdapter {
    public function fromDataToFields(array $data);
    public function fromRelationDataToFields(array $data);
}
