<?php
namespace iRESTful\Authenticated\Infrastructure\Controllers;
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

            use iRESTful\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
                use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
    
final class ConcreteRetrievePartialSet implements Controller {

    public function __construct(EntityPartialSetRepositoryFactory $entityPartialSetRepositoryFactory, EntityAdapterFactory $entityAdapterFactory) {
        $this->entityPartialSetRepositoryFactory = $entityPartialSetRepositoryFactory;
        $this->entityAdapterFactory = $entityAdapterFactory;
        
    }

    public function execute(HttpRequest $httpRequest) {
        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }
        
        $entitySet = $this->entityPartialSetFactory->create()->retrieve([
            'container' => isset($input["container"]) ? $input["container"] : null,
            'index' => isset($input["index"]) ? $input["index"] : null,
            'amount' => isset($input["amount"]) ? $input["amount"] : null,
        ]);
        
        $output = $this->entityAdapterFactory->create()->fromEntityPartialSetToData($entitySet);
        
        return $output;
        
        }


}
