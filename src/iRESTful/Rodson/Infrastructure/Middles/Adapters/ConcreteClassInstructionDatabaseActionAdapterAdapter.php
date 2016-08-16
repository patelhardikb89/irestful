<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Adapters\Adapters\InsertAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters\Adapters\UpdateAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters\Adapters\DeleteAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionAdapter;

final class ConcreteClassInstructionDatabaseActionAdapterAdapter implements ActionAdapterAdapter {
    private $insertAdapterAdapter;
    private $updateAdapterAdapter;
    private $deleteAdapterAdapter;
    public function __construct(InsertAdapterAdapter $insertAdapterAdapter, UpdateAdapterAdapter $updateAdapterAdapter, DeleteAdapterAdapter $deleteAdapterAdapter) {
        $this->insertAdapterAdapter = $insertAdapterAdapter;
        $this->updateAdapterAdapter = $updateAdapterAdapter;
        $this->deleteAdapterAdapter = $deleteAdapterAdapter;
    }

    public function fromDataToActionAdapter(array $data) {

        $httpRequests = null;
        if (isset($data['http_requests'])) {
            $httpRequests = $data['http_requests'];
        }

        $insertAdapter = $this->insertAdapterAdapter->fromDataToInsertAdapter($data);
        $updateAdapter = $this->updateAdapterAdapter->fromDataToUpdateAdapter($data);
        $deleteAdapter = $this->deleteAdapterAdapter->fromDataToDeleteAdapter($data);
        return new ConcreteClassInstructionDatabaseActionAdapter($insertAdapter, $updateAdapter, $deleteAdapter, $httpRequests);
    }

}
