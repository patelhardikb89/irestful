<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Adapters;

interface ForeignKeyAdapter {
    public function fromDataToForeignKey(array $data);
    public function fromContainerNameToForeignKey($containerName);
}
