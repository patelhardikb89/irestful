<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Updates\Update;
use iRESTful\Rodson\Instructions\Domain\Assignments\Assignment;

final class ConcreteInstructionDatabaseActionUpdate implements Update {
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

    public function getData() {
        return [
            'source' => $this->getSource()->getData(),
            'updated' => $this->getUpdated()->getData()
        ];
    }

}
