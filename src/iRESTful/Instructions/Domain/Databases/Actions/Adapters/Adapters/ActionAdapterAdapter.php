<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Adapters\Adapters;

interface ActionAdapterAdapter {
    public function fromDataToActionAdapter(array $data);
}
