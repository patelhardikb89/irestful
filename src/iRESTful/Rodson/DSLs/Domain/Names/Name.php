<?php
namespace iRESTful\Rodson\DSLs\Domain\Names;

interface Name {
    public function getName();
    public function getNameInParts();
    public function getProjectName();
    public function getOrganizationName();
}
