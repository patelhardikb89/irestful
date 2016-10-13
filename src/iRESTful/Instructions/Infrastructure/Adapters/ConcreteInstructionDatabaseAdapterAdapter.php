<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Adapters\Adapters\DatabaseAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Adapters\Adapters\RetrievalAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Exceptions\DatabaseException;

final class ConcreteInstructionDatabaseAdapterAdapter implements DatabaseAdapterAdapter {
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

        if (!isset($data['annotated_entities'])) {
            throw new DatabaseException('The annotated_entities keyname is mandatory in order to convert data to a DatabaseAdapter.');
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
            'annotated_entities' => $data['annotated_entities']
        ]);

        $actionAdapter = $this->actionAdapterAdapter->fromDataToActionAdapter([
            'previous_assignments' => $previousAssignments,
            'http_requests' => $httpRequests
        ]);

        return new ConcreteInstructionDatabaseAdapter($retrievalAdapter, $actionAdapter, $httpRequests);
    }

}
