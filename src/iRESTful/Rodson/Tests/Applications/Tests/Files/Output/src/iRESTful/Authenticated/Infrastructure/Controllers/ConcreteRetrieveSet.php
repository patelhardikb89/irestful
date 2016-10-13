<?php
namespace iRESTful\Authenticated\Infrastructure\Controllers;
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

            use iRESTful\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
    
final class ConcreteRetrieveSet implements Controller {

    public function __construct(EntitySetRepositoryFactory $entitySetRepositoryFactory, EntityAdapterFactory $entityAdapterFactory) {
        $this->entitySetRepositoryFactory = $entitySetRepositoryFactory;
        $this->entityAdapterFactory = $entityAdapterFactory;
        
    }

    public function execute(HttpRequest $httpRequest) {
        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }
        
        $entities = $this->entitySetRepositoryFactory->create()->retrieve([
            'container' => isset($input["container"]) ? $input["container"] : null
            'uuids' => 'uuid'
        ]);
        
        $output = $this->entityAdapterFactory->create()->fromEntitiesToData($entities);
        
        return $output;
        
        }


}
