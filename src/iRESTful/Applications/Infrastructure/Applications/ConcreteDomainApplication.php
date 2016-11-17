<?php
namespace iRESTful\Applications\Infrastructure\Applications;
use iRESTful\Applications\Domain\Application;
use iRESTful\Applications\Domain\Domains\Domain;
use iRESTful\Outputs\Domain\Codes\Adapters\Factories\CodeAdapterFactory;
use iRESTful\Outputs\Domain\Codes\Services\Factories\CodeServiceFactory;

final class ConcreteDomainApplication implements Application {
    private $codeServiceFactory;
    private $codeAdapterFactory;
    private $domain;
    public function __construct(CodeServiceFactory $codeServiceFactory, CodeAdapterFactory $codeAdapterFactory, Domain $domain) {
        $this->codeServiceFactory = $codeServiceFactory;
        $this->codeAdapterFactory = $codeAdapterFactory;
        $this->domain = $domain;
    }
    
    public function execute() {

        //we generate the code:
        $codeAdapter = $this->codeAdapterFactory->create();
        $annotatedObjectCodes = $codeAdapter->fromAnnotatedObjectsToCodes($this->domain->getObjects());
        $annotatedEntityCodes = $codeAdapter->fromAnnotatedEntitiesToCodes($this->domain->getEntities());
        $valueCodes = $codeAdapter->fromValuesToCodes($this->domain->getValues());

        //we save the codes on disk:
        $this->codeServiceFactory->create()->saveMultiple(array_merge(
            $annotatedObjectCodes,
            $annotatedEntityCodes,
            $valueCodes
        ));
    }

}
