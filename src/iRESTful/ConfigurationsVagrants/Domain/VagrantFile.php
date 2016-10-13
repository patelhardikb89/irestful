<?php
namespace iRESTful\ConfigurationsVagrants\Domain;

interface VagrantFile {
    public function getName();
    public function hasRelationalDatabase();
}
