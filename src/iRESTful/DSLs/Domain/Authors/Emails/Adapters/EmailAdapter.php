<?php
namespace iRESTful\DSLs\Domain\Authors\Emails\Adapters;

interface EmailAdapter {
    public function fromStringToEmail($string);
}
