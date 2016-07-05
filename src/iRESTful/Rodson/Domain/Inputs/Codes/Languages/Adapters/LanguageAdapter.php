<?php
namespace iRESTful\Rodson\Domain\Inputs\Codes\Languages\Adapters;

interface LanguageAdapter {
    public function fromStringToLanguage($string);
}
