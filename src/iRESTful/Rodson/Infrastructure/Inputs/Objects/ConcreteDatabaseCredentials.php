<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Credentials;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Exceptions\CredentialsException;

final class ConcreteDatabaseCredentials implements Credentials {
    private $username;
    private $password;
    public function __construct($username, $password = null) {

        if (empty($password)) {
            $password = null;
        }

        if (empty($username) || !is_string($username)) {
            throw new CredentialsException('The username must be a non-empty string.');
        }

        if (!empty($password) && !is_string($password)) {
            throw new CredentialsException('The password must be a string if non-empty.');
        }

        $this->username = $username;
        $this->password = $password;

    }

    public function getUsername() {
        return $this->username;
    }

    public function hasPassword() {
        return !empty($this->password);
    }

    public function getPassword() {
        return $this->password;
    }

}
