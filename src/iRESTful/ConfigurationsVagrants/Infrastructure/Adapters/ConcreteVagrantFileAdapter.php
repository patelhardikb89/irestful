<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Adapters;
use iRESTful\ConfigurationsVagrants\Domain\Adapters\VagrantFileAdapter;
use iRESTful\ConfigurationsVagrants\Infrastructure\Objects\ConcreteVagrantFile;
use iRESTful\ConfigurationsNginx\Domain\Adapters\NginxAdapter;
use iRESTful\DSLs\Domain\DSL;

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

        $name = str_replace('/', '-', $dsl->getName()->getName());
        $nginx = $this->nginxAdapter->fromDataToNginx([
            'name' => strtolower($name),
            'server_name' => strtolower($name).'.dev',
            'root' => [
                'file_name' => 'index.php',
                'directory_path' => 'web'
            ]
        ]);

        $hasRelDatabase = $hasRelationalDatabase($dsl);
        return new ConcreteVagrantFile($name, $nginx, $hasRelDatabase);
    }

}
