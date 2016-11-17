<?php
namespace iRESTful\Applications\Domain\Domains\Adapters;
use iRESTful\DSLs\Domain\Projects\Project;

interface DomainAdapter {
    public function fromProjectToDomain(Project $project);
}
