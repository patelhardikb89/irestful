<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseCredentials;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Exceptions\CredentialsException;

final class ConcreteDatabaseCredentialsTest extends \PHPUnit_Framework_TestCase {
    private $username;
    private $password;
    public function setUp() {
        $this->username = 'roger';
        $this->password = 'my password';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $credentials = new ConcreteDatabaseCredentials($this->username);

        $this->assertEquals($this->username, $credentials->getUsername());
        $this->assertFalse($credentials->hasPassword());
        $this->assertNull($credentials->getPassword());

    }

    public function testCreate_withEmptyPassword_Success() {

        $credentials = new ConcreteDatabaseCredentials($this->username, '');

        $this->assertEquals($this->username, $credentials->getUsername());
        $this->assertFalse($credentials->hasPassword());
        $this->assertNull($credentials->getPassword());

    }

    public function testCreate_withPassword_Success() {

        $credentials = new ConcreteDatabaseCredentials($this->username, $this->password);

        $this->assertEquals($this->username, $credentials->getUsername());
        $this->assertTrue($credentials->hasPassword());
        $this->assertEquals($this->password, $credentials->getPassword());

    }

    public function testCreate_withEmptyUsername_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteDatabaseCredentials('');

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
