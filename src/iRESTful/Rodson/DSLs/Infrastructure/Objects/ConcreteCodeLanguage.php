<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Languages\Language;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Languages\Exceptions\LanguageException;

final class ConcreteCodeLanguage implements Language {
    private $language;
    public function __construct(string $language) {

        if (empty($language)) {
            throw new LanguageException('The language must be a non-empty string.');
        }

        $this->language = $language;

    }

    public function get(): string {
        return $this->language;
    }

}
