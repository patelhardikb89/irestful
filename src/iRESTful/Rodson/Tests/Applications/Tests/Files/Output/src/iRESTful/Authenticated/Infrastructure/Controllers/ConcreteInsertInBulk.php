<?php
namespace iRESTful\Authenticated\Infrastructure\Controllers;
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

            use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
    
final class ConcreteInsertInBulk implements Controller {

    public function __construct(EntityAdapterFactory $entityAdapterFactory, EntityServiceFactory $entityServiceFactory) {
        $this->entityAdapterFactory = $entityAdapterFactory;
        $this->entityServiceFactory = $entityServiceFactory;
        
    }

    public function execute(HttpRequest $httpRequest) {
        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }
        
        $entities = $this->entityAdapterFactory->create()->fromDataToEntities(["container" => isset($input["container"]) ? $input["container"] : null, "data" => $input]);
        
        $this->entityServiceFactory->create()->insert($entities);
        
        $output = $this->entityAdapterFactory->create()->fromEntityToData($entities);
        
        return $output;
        
        }


}
