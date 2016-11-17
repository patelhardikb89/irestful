<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Authors\Emails\Adapters\EmailAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteAuthorEmail;

final class ConcreteAuthorEmailAdapter implements EmailAdapter {

    public function __construct() {

    }

    public function fromStringToEmail($string) {
        return new ConcreteAuthorEmail($string);
    }

}
