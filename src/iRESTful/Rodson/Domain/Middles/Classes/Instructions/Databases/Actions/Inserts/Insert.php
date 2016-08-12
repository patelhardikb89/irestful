<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts;

interface Insert {
    public function hasAssignment();
    public function getAssignment();
    public function hasAssignments();
    public function getAssignments();
}
