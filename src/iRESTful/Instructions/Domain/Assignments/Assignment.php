<?php
namespace iRESTful\Instructions\Domain\Assignments;

interface Assignment {
    public function getVariableName();
    public function hasDatabase();
    public function getDatabase();
    public function hasConversion();
    public function getConversion();
    public function hasMergedAssignments();
    public function getMergedAssignments();
    public function isPartialEntitySet();
    public function isMultipleEntities();
}
