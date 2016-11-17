<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Domain\Roots\Adapters;

interface RootAdapter {
    public function fromDataToRoot(array $data);
}
