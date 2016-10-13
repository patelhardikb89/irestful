<?php
namespace iRESTful\Authenticated\Infrastructure\Controllers;
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

            use iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
    
final class ConcreteDelete implements Controller {

    public function __construct(EntityRepositoryFactory $entityRepositoryFactory, EntityServiceFactory $entityServiceFactory, EntityAdapterFactory $entityAdapterFactory) {
        $this->entityRepositoryFactory = $entityRepositoryFactory;
        $this->entityServiceFactory = $entityServiceFactory;
        $this->entityAdapterFactory = $entityAdapterFactory;
        
    }

    public function execute(HttpRequest $httpRequest) {
        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }
        
        $entity = $this->entityRepositoryFactory->create()->retrieve([
            'container' => isset($input["container"]) ? $input["container"] : null
            'uuid' => isset($input["uuid"]) ? $input["uuid"] : null
        ]);
        
        $this->entityServiceFactory->create()->delete($entity);
        
        $output = $this->entityAdapterFactory->create()->fromEntityToData($entity);
        
        return $output;
        
        }


}
