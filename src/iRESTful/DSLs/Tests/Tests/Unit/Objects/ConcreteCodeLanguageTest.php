<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteCodeLanguage;
use iRESTful\DSLs\Domain\Projects\Codes\Languages\Exceptions\LanguageException;

final class ConcreteCodeLanguageTest extends \PHPUnit_Framework_TestCase {
    private $language;
    public function setUp() {
        $this->language = 'PHP';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $language = new ConcreteCodeLanguage($this->language);

        $this->assertEquals($this->language, $language->get());

    }

    public function testCreate_withEmptyLanguage_throwsLanguageException() {

        $asserted = false;
        try {

            new ConcreteCodeLanguage('');

        } catch (LanguageException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
