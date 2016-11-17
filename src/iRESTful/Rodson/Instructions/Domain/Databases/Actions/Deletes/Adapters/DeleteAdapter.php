<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Adapters;

interface DeleteAdapter {
    public function fromStringToDelete($string);
}
