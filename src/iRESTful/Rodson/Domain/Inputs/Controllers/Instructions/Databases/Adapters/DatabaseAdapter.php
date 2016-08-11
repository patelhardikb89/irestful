<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Adapters;

interface DatabaseAdapter {
    public function fromStringToDatabase($string);
}
