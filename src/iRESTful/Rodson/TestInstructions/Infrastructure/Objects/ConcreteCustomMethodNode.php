<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Objects;
use iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Nodes\CustomMethodNode;

final class ConcreteCustomMethodNode implements CustomMethodNode {
    private $customMethods;
    private $relatedCustomMethods;
    public function __construct(array $customMethods, array $relatedCustomMethods) {
        $this->customMethods = $customMethods;
        $this->relatedCustomMethods = $relatedCustomMethods;
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

    public function getRelatedCustomMethods() {
        return $this->relatedCustomMethods;
    }

}
