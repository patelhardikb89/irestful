<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Language;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Exceptions\LanguageException;

final class LanguageAdapterHelper {
    private $phpunit;
    private $languageAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, LanguageAdapter $languageAdapterMock) {
        $this->phpunit = $phpunit;
        $this->languageAdapterMock = $languageAdapterMock;
    }

    public function expectsFromStringToLanguage_Success(Language $returnedLanguage, $language) {
        $this->languageAdapterMock->expects($this->phpunit->once())
                                    ->method('fromStringToLanguage')
                                    ->with($language)
                                    ->will($this->phpunit->returnValue($returnedLanguage));
    }

    public function expectsFromStringToLanguage_throwsLanguageException($language) {
        $this->languageAdapterMock->expects($this->phpunit->once())
                                    ->method('fromStringToLanguage')
                                    ->with($language)
                                    ->will($this->phpunit->throwException(new LanguageException('TEST')));
    }

}
