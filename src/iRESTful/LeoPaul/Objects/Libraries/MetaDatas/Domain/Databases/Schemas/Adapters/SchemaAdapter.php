<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Adapters;

interface SchemaAdapter {
    public function fromDataToSchema(array $data);
}
