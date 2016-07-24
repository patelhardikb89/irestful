<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseCredentialsAdapter;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Exceptions\CredentialsException;

final class ConcreteDatabaseCredentialsAdapterTest extends \PHPUnit_Framework_TestCase {
    private $username;
    private $password;
    private $data;
    private $dataWithPassword;
    private $adapter;
    public function setUp() {
        $this->username = 'roger';
        $this->password = 'my_password';

        $this->data = [
            'username' => $this->username
        ];

        $this->dataWithPassword = [
            'username' => $this->username,
            'password' => $this->password
        ];

        $this->adapter = new ConcreteDatabaseCredentialsAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToCredentials_Success() {

        $credentials = $this->adapter->fromDataToCredentials($this->data);

        $this->assertEquals($this->username, $credentials->getUsername());
        $this->assertFalse($credentials->hasPassword());
        $this->assertNull($credentials->getPassword());

    }

    public function testFromDataToCredentials_withPassword_Success() {

        $credentials = $this->adapter->fromDataToCredentials($this->dataWithPassword);

        $this->assertEquals($this->username, $credentials->getUsername());
        $this->assertTrue($credentials->hasPassword());
        $this->assertEquals($this->password, $credentials->getPassword());

    }

    public function testFromDataToCredentials_withoutUsername_throwsCredentialsException() {

        unset($this->data['username']);

        $asserted = false;
        try {

            $this->adapter->fromDataToCredentials($this->data);

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
