<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteCodeLanguage;

final class ConcreteCodeLanguageAdapter implements LanguageAdapter {

    public function __construct() {

    }

    public function fromStringToLanguage($string) {
        return new ConcreteCodeLanguage($string);
    }

}
