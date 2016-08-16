<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\Adapters;

interface ActionAdapterAdapter {
    public function fromDataToActionAdapter(array $data);
}
