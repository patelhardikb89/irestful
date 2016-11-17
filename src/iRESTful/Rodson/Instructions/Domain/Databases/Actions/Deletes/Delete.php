<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes;

interface Delete {
    public function hasAssignment();
    public function getAssignment();
    public function hasAssignments();
    public function getAssignments();
}
