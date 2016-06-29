<?php
namespace iRESTful\Rodson\Domain\Codes\Languages\Adapters;

interface LanguageAdapter {
    public function fromStringToLanguage($string);
}
