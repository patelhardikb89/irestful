<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Language;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Exceptions\LanguageException;

final class ConcreteCodeLanguage implements Language {
    private $language;
    public function __construct($language) {

        if (empty($language) || !is_string($language)) {
            throw new LanguageException('The language must be a non-empty string.');
        }

        $this->language = $language;

    }

    public function get() {
        return $this->language;
    }

}
