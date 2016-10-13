<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Inserts\Adapters;

interface InsertAdapter {
    public function fromStringToInsert($string);
}
