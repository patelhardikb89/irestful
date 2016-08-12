<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Update;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;

final class ConcreteClassInstructionDatabaseActionUpdate implements Update {
    private $source;
    private $updated;
    public function __construct(Assignment $source, Assignment $updated) {
        $this->source = $source;
        $this->updated = $updated;
    }

    public function getSource() {
        return $this->source;
    }

    public function getUpdated() {
        return $this->updated;
    }

}
