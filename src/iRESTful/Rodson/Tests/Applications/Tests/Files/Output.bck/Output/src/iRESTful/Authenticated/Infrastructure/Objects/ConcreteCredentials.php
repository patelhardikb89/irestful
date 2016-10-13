<?php
namespace iRESTful\Authenticated\Infrastructure\Objects;
use iRESTful\Authenticated\Domain\Objects\Credentials;


final class ConcreteCredentials implements Credentials {
    private $username;
    private $hashedPassword;
    private $password;
    
    /**
    *   @username -> getUsername() -> username 
    *   @hashedPassword -> getHashedPassword() -> hashed_password 
    *   @password -> getPassword() -> password 
    */
    public function __construct($username, $hashedPassword, $password = null) {
        if (is_null($username) || !is_string($username)) {
            throw new \Exception("The username must be a non-null string.");
        }
        
        if (is_null($hashedPassword) || !is_string($hashedPassword)) {
            throw new \Exception("The hashedPassword must be a non-null string.");
        }
        
        if (!is_null($password) && !is_string($password)) {
            throw new \Exception("The password must be a string if non-null.");
        }
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
        $this->password = $password;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getHashedPassword() {
        return $this->hashedPassword;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
}
