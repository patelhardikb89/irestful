<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Inserts;

interface Insert {
    public function hasAssignment();
    public function getAssignment();
    public function hasAssignments();
    public function getAssignments();
}
