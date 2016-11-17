<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters\Adapters;

interface ActionAdapterAdapter {
    public function fromDataToActionAdapter(array $data);
}
