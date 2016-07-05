<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteCodeAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\LanguageAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Codes\Exceptions\CodeException;

final class ConcreteCodeAdapterTest extends \PHPUnit_Framework_TestCase {
    private $languageAdapterMock;
    private $languageMock;
    private $language;
    private $className;
    private $data;
    private $adapter;
    private $languageAdapterHelper;
    public function setUp() {
        $this->languageAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Languages\Adapters\LanguageAdapter');
        $this->languageMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Languages\Language');

        $this->language = 'PHP';
        $this->className = 'iRESTful\Rodson\Tests\Tests\Unit\Adapters\ConcreteCodeAdapterTest';

        $this->data = [
            'language' => $this->language,
            'class' => $this->className
        ];

        $this->adapter = new ConcreteCodeAdapter($this->languageAdapterMock);

        $this->languageAdapterHelper = new LanguageAdapterHelper($this, $this->languageAdapterMock);
    }

    public function tearDown() {

    }

    public function testfFromStringToLanguage_Success() {

        $this->languageAdapterHelper->expectsFromStringToLanguage_Success($this->languageMock, $this->language);

        $code = $this->adapter->fromDataToCode($this->data);

        $this->assertEquals($this->languageMock, $code->getLanguage());
        $this->assertEquals($this->className, $code->getClassName());

    }

    public function testfFromStringToLanguage_throwsLanguageException_throwsCodeException() {

        $this->languageAdapterHelper->expectsFromStringToLanguage_throwsLanguageException($this->language);

        $asserted = false;
        try {

            $this->adapter->fromDataToCode($this->data);

        } catch (CodeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfFromStringToLanguage_withoutClass_throwsCodeException() {

        unset($this->data['class']);

        $asserted = false;
        try {

            $this->adapter->fromDataToCode($this->data);

        } catch (CodeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfFromStringToLanguage_withoutLanguage_throwsCodeException() {

        unset($this->data['language']);

        $asserted = false;
        try {

            $this->adapter->fromDataToCode($this->data);

        } catch (CodeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
