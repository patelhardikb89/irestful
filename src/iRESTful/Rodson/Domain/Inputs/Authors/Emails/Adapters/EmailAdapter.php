<?php
namespace iRESTful\Rodson\Domain\Inputs\Authors\Emails\Adapters;

interface EmailAdapter {
    public function fromStringToEmail($string);
}
