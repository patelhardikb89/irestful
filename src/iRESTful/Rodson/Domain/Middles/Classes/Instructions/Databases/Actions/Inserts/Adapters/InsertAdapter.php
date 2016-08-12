<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Adapters;

interface InsertAdapter {
    public function fromStringToInsert($string);
}
