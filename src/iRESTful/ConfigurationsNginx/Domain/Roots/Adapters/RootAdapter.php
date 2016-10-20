<?php
namespace iRESTful\ConfigurationsNginx\Domain\Roots\Adapters;

interface RootAdapter {
    public function fromDataToRoot(array $data);
}
