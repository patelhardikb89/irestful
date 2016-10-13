<?php
namespace iRESTful\Instructions\Domain\Databases\Adapters;

interface DatabaseAdapter {
    public function fromStringToDatabase($string);
}
