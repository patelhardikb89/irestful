<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Code;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Languages\Language;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Exceptions\CodeException;

final class ConcreteCode implements Code {
    private $language;
    private $functions;
    public function __construct(Language $language, array $functions) {

        if (empty($functions)) {
            throw new CodeException('The functions array cannot be empty.');
        }

        foreach ($functions as $oneFunction) {
            if (!function_exists($oneFunction)) {
                throw new CodeException('The given function ('.$oneFunction.') does not exists.');
            }
        }

        $this->language = $language;
        $this->functions = $functions;
    }

    public function getLanguage(): Language {
        return $this->language;
    }

    public function getFunctions(): array {
        return $this->functions;
    }

}
