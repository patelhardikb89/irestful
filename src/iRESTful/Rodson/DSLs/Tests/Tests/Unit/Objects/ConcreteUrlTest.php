<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteUrl;
use iRESTful\Rodson\DSLs\Domain\URLs\Exceptions\UrlException;

final class ConcreteUrlTest extends \PHPUnit_Framework_TestCase {
    private $url;
    public function setUp() {
        $this->url = 'http://google.com/test.html';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $url = new ConcreteUrl($this->url);

        $this->assertEquals($this->url, $url->get());

    }

    public function testCreate_withInvalidUrl_throwsUrlException() {

        $asserted = false;
        try {

            new ConcreteUrl('invalid url');

        } catch (UrlException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
