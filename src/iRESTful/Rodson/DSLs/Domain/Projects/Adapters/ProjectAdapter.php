<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Adapters;

interface ProjectAdapter {
    public function fromDataToProject(array $data);
}
