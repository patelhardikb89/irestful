<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Code;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Languages\Language;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Exceptions\CodeException;

final class ConcreteCode implements Code {
    private $language;
    private $className;
    public function __construct(Language $language, $className) {

        if (empty($className) || !is_string($className)) {
            throw new CodeException('The className must be a non-empty string.');
        }

        if (!class_exists($className)) {
            throw new CodeException('The className ('.$className.') is invalid.');
        }

        $this->language = $language;
        $this->className = $className;

    }

    public function getLanguage() {
        return $this->language;
    }

    public function getClassName() {
        return $this->className;
    }

}
