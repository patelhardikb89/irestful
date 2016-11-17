<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\ClassMetaDataRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArrayMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArgumentMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTransformerAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteConstructorMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteClassMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Repositories\ReflectionClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTypeAdapter;

final class ReflectionClassMetaDataRepositoryFactory implements ClassMetaDataRepositoryFactory {
    private $containerClassMapper;
    private $interfaceClassMapper;
    public function __construct(array $containerClassMapper, array $interfaceClassMapper) {
        $this->containerClassMapper = $containerClassMapper;
        $this->interfaceClassMapper = $interfaceClassMapper;
    }

    public function create() {
        $transformerAdapter = new ConcreteTransformerAdapter();
        $arrayMetaDataAdapter = new ConcreteArrayMetaDataAdapter($transformerAdapter);
        $argumentMetaDataAdapter = new ConcreteArgumentMetaDataAdapter($arrayMetaDataAdapter);
        $typeAdapter = new ConcreteTypeAdapter();

        $constructorMetaDataAdapter = new ConcreteConstructorMetaDataAdapter($typeAdapter, $argumentMetaDataAdapter, $transformerAdapter);
        $classMetaDataAdapter = new ConcreteClassMetaDataAdapter($constructorMetaDataAdapter);
        return new ReflectionClassMetaDataRepository($classMetaDataAdapter, $this->containerClassMapper, $this->interfaceClassMapper);
    }

}
