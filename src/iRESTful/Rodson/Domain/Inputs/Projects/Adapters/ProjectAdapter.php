<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Adapters;

interface ProjectAdapter {
    public function fromDataToProject(array $data);
    public function fromDataToProjects(array $data);
}
