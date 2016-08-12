<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters;

interface DeleteAdapter {
    public function fromStringToDelete($string);
}
