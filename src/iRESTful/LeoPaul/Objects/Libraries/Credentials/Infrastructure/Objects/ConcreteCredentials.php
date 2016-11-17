<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Credentials\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Credentials\Domain\Credentials;
use iRESTful\LeoPaul\Objects\Libraries\Credentials\Domain\Exceptions\CredentialsException;

final class ConcreteCredentials implements Credentials {
    private $username;
    private $password;

    /**
    *   @username -> getUsername() -> user
    *   @password -> getPassword() -> pass
    */
    public function __construct($username, $password) {

        if (empty($username) || !is_string($username)) {
            throw new CredentialsException('The username must be a non-empty string.');
        }

        if (empty($password) || !is_string($password)) {
            throw new CredentialsException('The password must be a non-empty string.');
        }

        $this->username = $username;
        $this->password = $password;

    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

}
