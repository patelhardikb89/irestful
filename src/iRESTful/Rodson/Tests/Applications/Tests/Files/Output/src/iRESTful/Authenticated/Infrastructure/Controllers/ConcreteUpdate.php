<?php
namespace iRESTful\Authenticated\Infrastructure\Controllers;
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

            use iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
    
final class ConcreteUpdate implements Controller {

    public function __construct(EntityRepositoryFactory $entityRepositoryFactory, EntityAdapterFactory $entityAdapterFactory, EntityServiceFactory $entityServiceFactory) {
        $this->entityRepositoryFactory = $entityRepositoryFactory;
        $this->entityAdapterFactory = $entityAdapterFactory;
        $this->entityServiceFactory = $entityServiceFactory;
        
    }

    public function execute(HttpRequest $httpRequest) {
        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }
        
        $original = $this->entityRepositoryFactory->create()->retrieve([
            'container' => isset($input["container"]) ? $input["container"] : null
            'uuid' => isset($input["uuid"]) ? $input["uuid"] : null
        ]);
        
        $updated = $this->entityAdapterFactory->create()->fromDataToEntity(["container" => isset($input["container"]) ? $input["container"] : null, "data" => $input]);
        
        $this->entityServiceFactory->create()->update($original, $updated);
        
        $output = $this->entityAdapterFactory->create()->fromEntityToData($updated);
        
        return $output;
        
        }


}
