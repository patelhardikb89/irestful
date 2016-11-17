<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services\StrategyEntityService;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityAdapterFactory;

final class StrategyEntityServiceFactory implements EntityServiceFactory {
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
        return new StrategyEntityService($enttiyAdapter, $this->containerServiceMapper);
    }

}
