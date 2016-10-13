<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Codes\Languages\Adapters\LanguageAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteCodeLanguage;

final class ConcreteCodeLanguageAdapter implements LanguageAdapter {

    public function __construct() {

    }

    public function fromStringToLanguage($string) {
        return new ConcreteCodeLanguage($string);
    }

}
