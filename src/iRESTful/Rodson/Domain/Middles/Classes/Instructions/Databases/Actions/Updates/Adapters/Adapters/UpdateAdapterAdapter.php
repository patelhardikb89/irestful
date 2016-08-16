<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters\Adapters;

interface UpdateAdapterAdapter {
    public function fromDataToUpdateAdapter(array $data);
}
