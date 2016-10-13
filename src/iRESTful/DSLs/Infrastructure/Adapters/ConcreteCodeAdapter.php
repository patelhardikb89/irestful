<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Codes\Adapters\CodeAdapter;
use iRESTful\DSLs\Domain\Projects\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteCode;
use iRESTful\DSLs\Domain\Projects\Codes\Exceptions\CodeException;
use iRESTful\DSLs\Domain\Projects\Codes\Languages\Exceptions\LanguageException;

final class ConcreteCodeAdapter implements CodeAdapter {
    private $languageAdapter;
    private $baseDirectory;
    public function __construct(LanguageAdapter $languageAdapter, $baseDirectory) {
        $this->languageAdapter = $languageAdapter;
        $this->baseDirectory = $baseDirectory;
    }

    public function fromDataToCode(array $data) {

        if (!isset($data['language'])) {
            throw new CodeException('The language keyname is mandatory in order to convert data to a Code object.');
        }

        if (!isset($data['class'])) {
            throw new CodeException('The class keyname is mandatory in order to convert data to a Code object.');
        }

        if (!isset($data['file'])) {
            throw new CodeException('The file keyname is mandatory in order to convert data to a Code object.');
        }

        try {

            $file = $this->baseDirectory.'/'.$data['file'];
            if (!file_exists($file)) {
                throw new CodeException('The given file ('.$data['file'].') does not exists.  The base directory was: '.$this->baseDirectory.' - The absolute file path was supposed to be: '.$file);
            }

            include_once($file);
            $language = $this->languageAdapter->fromStringToLanguage($data['language']);
            return new ConcreteCode($language, $data['class']);

        } catch (LanguageException $exception) {
            throw new CodeException('There was an exception while converting a string to a Language object.', $exception);
        }

    }

}
