<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Codes\Code;
use iRESTful\Rodson\Domain\Codes\Languages\Language;
use iRESTful\Rodson\Domain\Codes\Exceptions\CodeException;

final class ConcreteCode implements Code {
    private $language;
    private $code;
    public function __construct(Language $language, $code) {

        if (empty($code) || !is_string($code)) {
            throw new CodeException('The code must be a non-empty string.');
        }

        $this->language = $language;
        $this->code = $code;

    }

    public function getLanguage() {
        return $this->language;
    }

    public function get() {
        return $this->code;
    }

}
