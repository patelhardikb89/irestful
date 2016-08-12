<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters;

interface UpdateAdapter {
    public function fromStringToUpdate($string);
}
