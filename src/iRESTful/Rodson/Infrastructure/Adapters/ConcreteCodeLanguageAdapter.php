<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteCodeLanguage;

final class ConcreteCodeLanguageAdapter implements LanguageAdapter {

    public function __construct() {

    }

    public function fromStringToLanguage($string) {
        return new ConcreteCodeLanguage($string);
    }

}
