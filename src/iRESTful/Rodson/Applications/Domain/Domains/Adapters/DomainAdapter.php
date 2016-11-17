<?php
namespace iRESTful\Rodson\Applications\Domain\Domains\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Project;

interface DomainAdapter {
    public function fromProjectToDomain(Project $project);
}
