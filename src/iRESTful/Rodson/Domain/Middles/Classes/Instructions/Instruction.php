<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions;

interface Instruction {
    public function hasDatabase();
    public function getDatabase();
    public function hasConversion();
    public function getConversion();
    public function hasMergeAssignments();
    public function getMergeAssignments();
    public function hasAssignment();
    public function getAssignment();
}
