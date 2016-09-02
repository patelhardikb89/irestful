<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Adapters\Adapters\DatabaseAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters\Adapters\RetrievalAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Exceptions\DatabaseException;

final class ConcreteClassInstructionDatabaseAdapterAdapter implements DatabaseAdapterAdapter {
    private $retrievalAdapterAdapter;
    private $actionAdapterAdapter;
    public function __construct(RetrievalAdapterAdapter $retrievalAdapterAdapter, ActionAdapterAdapter $actionAdapterAdapter) {
        $this->retrievalAdapterAdapter = $retrievalAdapterAdapter;
        $this->actionAdapterAdapter = $actionAdapterAdapter;
    }

    public function fromDataToDatabaseAdapter(array $data) {

        if (!isset($data['controller'])) {
            throw new DatabaseException('The controller keyname is mandatory in order to convert data to a DatabaseAdapter.');
        }

        if (!isset($data['annotated_classes'])) {
            throw new DatabaseException('The annotated_classes keyname is mandatory in order to convert data to a DatabaseAdapter.');
        }

        $previousAssignments = [];
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        $httpRequests = null;
        if ($data['controller']->hasHttpRequests()) {
            $httpRequests = $data['controller']->getHttpRequests();
        }

        $constants = null;
        if ($data['controller']->hasConstants()) {
            $constants = $data['controller']->getConstants();
        }
        
        $retrievalAdapter = $this->retrievalAdapterAdapter->fromDataToRetrievalAdapter([
            'constants' => $constants,
            'annotated_classes' => $data['annotated_classes']
        ]);

        $actionAdapter = $this->actionAdapterAdapter->fromDataToActionAdapter([
            'previous_assignments' => $previousAssignments,
            'http_requests' => $httpRequests
        ]);

        return new ConcreteClassInstructionDatabaseAdapter($retrievalAdapter, $actionAdapter, $httpRequests);
    }

}
