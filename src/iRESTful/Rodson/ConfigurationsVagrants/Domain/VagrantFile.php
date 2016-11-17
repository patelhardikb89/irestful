<?php
namespace iRESTful\Rodson\ConfigurationsVagrants\Domain;

interface VagrantFile {
    public function getName();
    public function getDatabaseName();
    public function getNginx();
    public function hasRelationalDatabase();
}
