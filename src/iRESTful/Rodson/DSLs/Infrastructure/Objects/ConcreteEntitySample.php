<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Sample;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Exceptions\SampleException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\References\Reference;

final class ConcreteEntitySample implements Sample {
    private $name;
    private $additions;
    private $references;
    private $normalizedReferences;
    private $parentReferences;
    public function __construct($name, array $additions = null, array $references = null, array $normalizedReferences = null) {

        if (empty($additions)) {
            $additions = null;
        }

        if (empty($references)) {
            $references = null;
        }

        if (empty($normalizedReferences)) {
            $normalizedReferences = null;
        }

        if (empty($parentReferences)) {
            $parentReferences = null;
        }

        if (!empty($references)) {
            foreach($references as $oneReference) {
                if (!($oneReference instanceof Reference)) {
                    throw new SampleException('The references array must only contain Reference objects.');
                }
            }
        }

        $this->name = $name;
        $this->additions = $additions;
        $this->references = $references;
        $this->normalizedReferences = $normalizedReferences;
    }

    public function getName() {
        return $this->name;
    }

    public function hasAdditions() {
        return !empty($this->additions);
    }

    public function getAdditions() {
        return $this->additions;
    }

    public function hasReferences() {
        return !empty($this->references);
    }

    public function getReferences() {
        return $this->references;
    }

    public function hasNormalizedReferences() {
        return !empty($this->normalizedReferences);
    }

    public function getNormalizedReferences() {
        return $this->normalizedReferences;
    }
}
