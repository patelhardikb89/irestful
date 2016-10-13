<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Updates\Adapters\Adapters;

interface UpdateAdapterAdapter {
    public function fromDataToUpdateAdapter(array $data);
}
