<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Authors\Emails\Email;

final class ConcreteAuthorEmail implements Email {
    private $email;
    public function __construct($email) {
        $this->email = $email;
    }

    public function get() {
        return $this->email;
    }
}
