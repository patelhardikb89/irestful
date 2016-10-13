<?php
namespace iRESTful\Authenticated\Infrastructure\Controllers;
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

            use iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
    
final class ConcreteRetrieveByKeyname implements Controller {

    public function __construct(EntityRepositoryFactory $entityRepositoryFactory, EntityAdapterFactory $entityAdapterFactory) {
        $this->entityRepositoryFactory = $entityRepositoryFactory;
        $this->entityAdapterFactory = $entityAdapterFactory;
        
    }

    public function execute(HttpRequest $httpRequest) {
        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }
        
        $entity = $this->entityRepositoryFactory->create()->retrieve([
            'container' => isset($input["container"]) ? $input["container"] : null
            'keyname' => [
                'name' => isset($input["name"]) ? $input["name"] : null
                'value' => isset($input["value"]) ? $input["value"] : null
            ]
        ]);
        
        $output = $this->entityAdapterFactory->create()->fromEntityToData($entity);
        
        return $output;
        
        }


}
