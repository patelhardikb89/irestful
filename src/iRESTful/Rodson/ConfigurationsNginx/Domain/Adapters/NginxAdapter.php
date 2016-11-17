<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Domain\Adapters;

interface NginxAdapter {
    public function fromDataToNginx(array $data);
}
