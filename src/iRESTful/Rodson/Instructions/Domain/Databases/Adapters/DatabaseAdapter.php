<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Adapters;

interface DatabaseAdapter {
    public function fromStringToDatabase($string);
}
