<?php
namespace iRESTful\DSLs\Domain\Projects\Adapters;

interface ProjectAdapter {
    public function fromDataToProject(array $data);
}
