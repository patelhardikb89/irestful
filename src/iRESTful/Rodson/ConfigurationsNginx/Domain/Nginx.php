<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Domain;

interface Nginx {
    public function getName();
    public function getServerName();
    public function getRoot();
}
