<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes;

interface Delete {
    public function hasAssignment();
    public function getAssignment();
    public function hasAssignments();
    public function getAssignments();
    public function getData();
}
