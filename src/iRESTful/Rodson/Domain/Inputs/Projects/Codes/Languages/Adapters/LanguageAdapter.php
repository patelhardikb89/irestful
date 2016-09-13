<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Codes\Languages\Adapters;

interface LanguageAdapter {
    public function fromStringToLanguage($string);
}
