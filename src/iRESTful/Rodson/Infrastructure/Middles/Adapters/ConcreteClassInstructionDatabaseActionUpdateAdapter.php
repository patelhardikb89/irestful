<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters\UpdateAdapter;

final class ConcreteClassInstructionDatabaseActionUpdateAdapter implements UpdateAdapter {
    private $previousAssignments;
    private $httpRequests;
    public function __construct(array $previousAssignments = null, array $httpRequests = null) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        if (empty($httpRequests)) {
            $httpRequests = [];
        }

        $this->previousAssignments = $previousAssignments;
        $this->httpRequests = $httpRequests;

    }

    public function fromStringToUpdate($string) {

        
        print_r([$string, 'update']);
        die();
    }

}
