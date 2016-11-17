<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityRelationRepositoryFactory;

final class StrategyEntityAdapterFactory implements EntityAdapterFactory {
    private $containerRepositoryMapper;
    private $transformerObjects;
    private $containerClassMapper;
    private $interfaceClassMapper;
    private $delimiter;
    public function __construct(
        array $containerRepositoryMapper,
        array $transformerObjects,
        array $containerClassMapper,
        array $interfaceClassMapper,
        $delimiter
    ) {
        $this->containerRepositoryMapper = $containerRepositoryMapper;
        $this->transformerObjects = $transformerObjects;
        $this->containerClassMapper = $containerClassMapper;
        $this->interfaceClassMapper = $interfaceClassMapper;
        $this->delimiter = $delimiter;
    }

    public function create() {

        $entityRepositoryFactory = new StrategyEntityRepositoryFactory($this->containerRepositoryMapper);
        $entityRepository = $entityRepositoryFactory->create();

        $entityRelationRepositoryFactory = new StrategyEntityRelationRepositoryFactory($this->containerRepositoryMapper);
        $entityRelationRepository = $entityRelationRepositoryFactory->create();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        return $entityAdapterAdapter->fromRepositoriesToEntityAdapter($entityRepository, $entityRelationRepository);

    }

}
