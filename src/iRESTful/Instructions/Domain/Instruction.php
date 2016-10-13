<?php
namespace iRESTful\Instructions\Domain;

interface Instruction {
    public function hasMergeAssignments();
    public function getMergeAssignments();
    public function hasAssignment();
    public function getAssignment();
    public function hasAction();
    public function getAction();
}
