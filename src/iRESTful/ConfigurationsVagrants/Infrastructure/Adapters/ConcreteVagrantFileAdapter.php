<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Adapters;
use iRESTful\ConfigurationsVagrants\Domain\Adapters\VagrantFileAdapter;
use iRESTful\DSLs\Domain\DSL;
use iRESTful\ConfigurationsVagrants\Infrastructure\Objects\ConcreteVagrantFile;

final class ConcreteVagrantFileAdapter implements VagrantFileAdapter {

    public function __construct() {

    }

    public function fromDSLToVagrantFile(DSL $dsl) {

        $hasRelationalDatabase = function(DSL $dsl) use(&$hasRelationalDatabase) {
            $project = $dsl->getProject();
            $objects = $project->getObjects();
            foreach($objects as $oneObject) {

                if (!$oneObject->hasDatabase()) {
                    continue;
                }

                $database = $oneObject->getDatabase();
                if (!$database->hasRelational()) {
                    continue;
                }

                return true;
            }

            return false;
        };

        $name = str_replace('/', '-', $dsl->getName()->getName());
        $hasRelDatabase = $hasRelationalDatabase($dsl);
        return new ConcreteVagrantFile($name, $hasRelDatabase);
    }

}
