<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\Keyname;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\MetaData;

final class ConcreteClassInstructionValueLoopKeyname implements Keyname {
    private $name;
    private $metaData;
    public function __construct($name, MetaData $metaData = null) {
        $this->name = $name;
        $this->metaData = $metaData;
    }

    public function getName() {
        return $this->name;
    }

    public function hasMetaData() {
        return !empty($this->metaData);
    }

    public function getMetaData() {
        return $this->metaData;
    }

}
