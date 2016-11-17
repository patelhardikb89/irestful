<?php
namespace iRESTful\Rodson\ConfigurationsVagrants\Infrastructure\Adapters;
use iRESTful\Rodson\ConfigurationsVagrants\Domain\Adapters\VagrantFileAdapter;
use iRESTful\Rodson\ConfigurationsVagrants\Infrastructure\Objects\ConcreteVagrantFile;
use iRESTful\Rodson\ConfigurationsNginx\Domain\Adapters\NginxAdapter;
use iRESTful\Rodson\DSLs\Domain\DSL;

final class ConcreteVagrantFileAdapter implements VagrantFileAdapter {
    private $nginxAdapter;
    public function __construct(NginxAdapter $nginxAdapter) {
        $this->nginxAdapter = $nginxAdapter;
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

        $dslName = $dsl->getName()->getName();
        $name = strtolower(str_replace('/', '-', $dslName));
        $databaseName = strtolower(str_replace('/', '_', $dslName));
        $nginx = $this->nginxAdapter->fromDataToNginx([
            'name' => $name,
            'server_name' => $name.'.dev',
            'root' => [
                'file_name' => 'index.php',
                'directory_path' => 'web'
            ]
        ]);

        $hasRelDatabase = $hasRelationalDatabase($dsl);
        return new ConcreteVagrantFile($name, $databaseName, $nginx, $hasRelDatabase);
    }

}
