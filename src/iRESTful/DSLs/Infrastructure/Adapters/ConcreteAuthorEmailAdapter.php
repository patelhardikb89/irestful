<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Authors\Emails\Adapters\EmailAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteAuthorEmail;

final class ConcreteAuthorEmailAdapter implements EmailAdapter {

    public function __construct() {

    }

    public function fromStringToEmail($string) {
        return new ConcreteAuthorEmail($string);
    }

}
