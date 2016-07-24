<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteCodeLanguage;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Exceptions\LanguageException;

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

    public function testCreate_withNonStringLanguage_throwsLanguageException() {

        $asserted = false;
        try {

            new ConcreteCodeLanguage(new \DateTime());

        } catch (LanguageException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
