<?php
namespace iRESTful\Authenticated\Infrastructure\Objects;
use iRESTful\Authenticated\Domain\Objects\Credentials;

            
final class ConcreteCredentials implements Credentials {
    private $username;
        private $hashedPassword;
        private $password;
        

    /**
    *   @username -> getUsername() -> username ## @string specific -> 255  
    *   @hashedPassword -> getHashedPassword() -> hashed_password ## @string specific -> 255  
    *   @password -> getPassword() -> password ## @string specific -> 255  
    */

    public function __construct($username, $hashedPassword, $password) {
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
