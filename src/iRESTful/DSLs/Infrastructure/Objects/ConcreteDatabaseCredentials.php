<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Credentials;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Exceptions\CredentialsException;

final class ConcreteDatabaseCredentials implements Credentials {
    private $username;
    private $password;
    public function __construct(string $username, string $password = null) {

        if (empty($password)) {
            $password = null;
        }

        if (empty($username)) {
            throw new CredentialsException('The username must be a non-empty string.');
        }

        $this->username = $username;
        $this->password = $password;

    }

    public function getUsername(): string {
        return $this->username;
    }

    public function hasPassword(): bool {
        return !empty($this->password);
    }

    public function getPassword() {
        return $this->password;
    }
}
