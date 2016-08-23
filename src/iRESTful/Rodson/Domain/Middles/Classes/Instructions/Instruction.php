<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions;

interface Instruction {
    public function hasMergeAssignments();
    public function getMergeAssignments();
    public function hasAssignment();
    public function getAssignment();
    public function hasAction();
    public function getAction();
    public function getData();
}
