<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteCodeLanguage;

final class ConcreteCodeLanguageAdapter implements LanguageAdapter {

    public function __construct() {

    }

    public function fromStringToLanguage($string) {
        return new ConcreteCodeLanguage($string);
    }

}
