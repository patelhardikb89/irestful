<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteAuthorEmail;
use iRESTful\Rodson\DSLs\Domain\Authors\Emails\Exceptions\EmailException;

final class ConcreteAuthorEmailTest extends \PHPUnit_Framework_TestCase {
    private $email;
    public function setUp() {
        $this->email = 'steve@rodson.io';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $email = new ConcreteAuthorEmail($this->email);

        $this->assertEquals($this->email, $email->get());

    }

    public function testCreate_withInvalidEmail_throwsEmailException() {

        $asserted = false;
        try {

            new ConcreteAuthorEmail('invalid email address @ test');

        } catch (EmailException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
