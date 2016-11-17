<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services\StrategyEntitySetService;

final class StrategyEntitySetServiceFactory implements EntitySetServiceFactory {
    private $containerServiceMapper;
    private $containerRepositoryMapper;
    private $transformerObjects;
    private $containerClassMapper;
    private $interfaceClassMapper;
    private $delimiter;
    public function __construct(
        array $containerServiceMapper,
        array $containerRepositoryMapper,
        array $transformerObjects,
        array $containerClassMapper,
        array $interfaceClassMapper,
        $delimiter
    ) {
        $this->containerServiceMapper = $containerServiceMapper;
        $this->containerRepositoryMapper = $containerRepositoryMapper;
        $this->transformerObjects = $transformerObjects;
        $this->containerClassMapper = $containerClassMapper;
        $this->interfaceClassMapper = $interfaceClassMapper;
        $this->delimiter = $delimiter;
    }

    public function create() {

        $entityAdapterFactory = new StrategyEntityAdapterFactory(
            $this->containerRepositoryMapper,
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter
        );

        $enttiyAdapter = $entityAdapterFactory->create();
        return new StrategyEntitySetService($enttiyAdapter, $this->containerServiceMapper);
    }

}
