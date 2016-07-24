<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteCodeLanguageAdapter;

final class ConcreteCodeLanguageAdapterTest extends \PHPUnit_Framework_TestCase {
    private $language;
    private $adapter;
    public function setUp() {
        $this->language = 'PHP';

        $this->adapter = new ConcreteCodeLanguageAdapter();
    }

    public function tearDown() {

    }

    public function testFromStringToLanguage_Success() {
        $language = $this->adapter->fromStringToLanguage($this->language);

        $this->assertEquals($this->language, $language->get());

    }

}
