<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteAuthor;

final class ConcreteAuthorTest extends \PHPUnit_Framework_TestCase {
    private $emailMock;
    private $urlMock;
    private $name;
    public function setUp() {
        $this->emailMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Authors\Emails\Email');
        $this->urlMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\URLs\Url');

        $this->name = 'Steve Rodrigue';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $author = new ConcreteAuthor($this->name, $this->emailMock);

        $this->assertEquals($this->name, $author->getName());
        $this->assertEquals($this->emailMock, $author->getEmail());
        $this->assertFalse($author->hasUrl());
        $this->assertNull($author->getUrl());

    }

    public function testCreate_withUrl_Success() {

        $author = new ConcreteAuthor($this->name, $this->emailMock, $this->urlMock);

        $this->assertEquals($this->name, $author->getName());
        $this->assertEquals($this->emailMock, $author->getEmail());
        $this->assertTrue($author->hasUrl());
        $this->assertEquals($this->urlMock, $author->getUrl());

    }

}
