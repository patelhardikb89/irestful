<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Code;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Languages\Language;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Exceptions\CodeException;

final class ConcreteCode implements Code {
    private $language;
    private $className;
    public function __construct(Language $language, string $className) {

        if (!class_exists($className)) {
            throw new CodeException('The className ('.$className.') is invalid.');
        }

        $this->language = $language;
        $this->className = $className;

    }

    public function getLanguage(): Language {
        return $this->language;
    }

    public function getClassName(): string {
        return $this->className;
    }

}
