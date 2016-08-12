<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Adapters;

interface DatabaseAdapter {
    public function fromStringToDatabase($string);
}
