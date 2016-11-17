<?php
namespace iRESTful\Rodson\DSLs\Domain\Authors\Emails\Adapters;

interface EmailAdapter {
    public function fromStringToEmail($string);
}
