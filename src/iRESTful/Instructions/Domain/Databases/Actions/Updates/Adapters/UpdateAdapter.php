<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Updates\Adapters;

interface UpdateAdapter {
    public function fromStringToUpdate($string);
}
