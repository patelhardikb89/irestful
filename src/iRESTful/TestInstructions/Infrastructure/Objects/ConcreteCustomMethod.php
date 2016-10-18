<?php
namespace iRESTful\TestInstructions\Infrastructure\Objects;
use iRESTful\TestInstructions\Domain\CustomMethods\CustomMethod as TestCustomMethod;
use iRESTful\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\TestInstructions\Domain\CustomMethods\Exceptions\CustomMethodException;
use iRESTful\Classes\Domain\CustomMethods\SourceCodes\SourceCode;

final class ConcreteCustomMethod implements TestCustomMethod {
    private $name;
    private $sourceCode;
    private $relatedCustomMethods;
    public function __construct($name, SourceCode $sourceCode, array $relatedCustomMethods = null) {

        if (empty($relatedCustomMethods)) {
            $relatedCustomMethods = null;
        }

        if (!empty($relatedCustomMethods)) {
            foreach($relatedCustomMethods as $oneCustomMethod) {
                if (!($oneCustomMethod instanceof CustomMethod)) {
                    throw new CustomMethodException('The relatedCustomMethods can only contain CustomMethod objects if non-empty.');
                }
            }
        }

        $this->name = $name;
        $this->sourceCode = $sourceCode;
        $this->relatedCustomMethods = $relatedCustomMethods;

    }

    public function getName() {
        return $this->name;
    }

    public function getSourceCode() {
        return $this->sourceCode;
    }

    public function hasRelatedCustomMethods() {
        return !empty($this->relatedCustomMethods);
    }

    public function getRelatedCustomMethods() {
        return $this->relatedCustomMethods;
    }

}
