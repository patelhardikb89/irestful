<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteDatabaseCredentials;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Exceptions\CredentialsException;

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

    public function testCreate_withNonStringPassword_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteDatabaseCredentials($this->username, new \DateTime());

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

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

    public function testCreate_withNonStringUsername_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteDatabaseCredentials(new \DateTime());

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
