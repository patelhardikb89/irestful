<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteCode;
use iRESTful\Rodson\Domain\Inputs\Codes\Exceptions\CodeException;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Exceptions\LanguageException;

final class ConcreteCodeAdapter implements CodeAdapter {
    private $languageAdapter;
    public function __construct(LanguageAdapter $languageAdapter) {
        $this->languageAdapter = $languageAdapter;
    }

    public function fromDataToCode(array $data) {

        if (!isset($data['language'])) {
            throw new CodeException('The language keyname is mandatory in order to convert data to a Code object.');
        }

        if (!isset($data['class'])) {
            throw new CodeException('The class keyname is mandatory in order to convert data to a Code object.');
        }

        try {

            $language = $this->languageAdapter->fromStringToLanguage($data['language']);
            return new ConcreteCode($language, $data['class']);

        } catch (LanguageException $exception) {
            throw new CodeException('There was an exception while converting a string to a Language object.', $exception);
        }

    }

}
