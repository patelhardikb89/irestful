<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\VagrantFiles\Adapters\VagrantFileAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteVagrantFile;

final class ConcreteVagrantFileAdapter implements VagrantFileAdapter {

    public function __construct() {

    }

    public function fromRodsonToVagrantFile(Rodson $rodson) {

        $hasRelationalDatabase = function(Rodson $rodson) use(&$hasRelationalDatabase) {
            $project = $rodson->getProject();
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

        $name = str_replace('/', '-', $rodson->getName()->getName());
        $hasRelDatabase = $hasRelationalDatabase($rodson);
        return new ConcreteVagrantFile($name, $hasRelDatabase);
    }

}
