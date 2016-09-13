<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Authors\Emails\Adapters\EmailAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteAuthorEmail;

final class ConcreteAuthorEmailAdapter implements EmailAdapter {

    public function __construct() {

    }

    public function fromStringToEmail($string) {
        return new ConcreteAuthorEmail($string);
    }

}
