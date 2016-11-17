<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Inserts\Adapters\Adapters\InsertAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Updates\Adapters\Adapters\UpdateAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Adapters\Adapters\DeleteAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionAdapter;

final class ConcreteInstructionDatabaseActionAdapterAdapter implements ActionAdapterAdapter {
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
        return new ConcreteInstructionDatabaseActionAdapter($insertAdapter, $updateAdapter, $deleteAdapter, $httpRequests);
    }

}
