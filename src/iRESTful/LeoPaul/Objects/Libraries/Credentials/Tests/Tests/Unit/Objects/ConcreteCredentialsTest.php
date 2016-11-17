<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Credentials\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Credentials\Infrastructure\Objects\ConcreteCredentials;
use iRESTful\LeoPaul\Objects\Libraries\Credentials\Domain\Exceptions\CredentialsException;

final class ConcreteCredentialsTest extends \PHPUnit_Framework_TestCase {
    private $username;
    private $password;
    public function setUp() {
        $this->username = 'my_username';
        $this->password = 'my_password';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $credentials = new ConcreteCredentials($this->username, $this->password);

        $this->assertEquals($this->username, $credentials->getUsername());
        $this->assertEquals($this->password, $credentials->getPassword());

    }

    public function testCreate_withEmptyPassword_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteCredentials($this->username, '');

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_witNonStringPassword_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteCredentials($this->username, new \DateTime());

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyUsername_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteCredentials('', $this->password);

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_witNonStringUsername_throwsCredentialsException() {

        $asserted = false;
        try {

            new ConcreteCredentials(new \DateTime(), $this->password);

        } catch (CredentialsException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
