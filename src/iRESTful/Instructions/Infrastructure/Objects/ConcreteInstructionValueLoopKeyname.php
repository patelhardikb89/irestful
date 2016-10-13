<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Keyname;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\MetaData;

final class ConcreteInstructionValueLoopKeyname implements Keyname {
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
