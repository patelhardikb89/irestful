<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Updates\Adapters;

interface UpdateAdapter {
    public function fromStringToUpdate($string);
}
