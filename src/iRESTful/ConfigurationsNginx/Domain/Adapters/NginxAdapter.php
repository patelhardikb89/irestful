<?php
namespace iRESTful\ConfigurationsNginx\Domain\Adapters;

interface NginxAdapter {
    public function fromDataToNginx(array $data);
}
