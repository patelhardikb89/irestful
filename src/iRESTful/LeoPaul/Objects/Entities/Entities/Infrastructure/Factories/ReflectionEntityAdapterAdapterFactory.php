<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\Factories\EntityAdapterAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionClassMetaDataRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionObjectAdapterFactoryAdapter;

final class ReflectionEntityAdapterAdapterFactory implements EntityAdapterAdapterFactory {
    private $transformerObjects;
	private $containerClassMapper;
	private $interfaceClassMapper;
	private $delimiter;
	public function __construct(
        array $transformerObjects,
        array $containerClassMapper,
        array $interfaceClassMapper,
        $delimiter
    ) {
		$this->transformerObjects = $transformerObjects;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->delimiter = $delimiter;
	}

    public function create() {

        $objectAdapterFactoryAdapter = new ReflectionObjectAdapterFactoryAdapter();
        $objectAdapter = $objectAdapterFactoryAdapter->fromDataToObjectAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        $classMetaDataRepositoryFactoryAdapter = new ReflectionClassMetaDataRepositoryFactoryAdapter();
        $classMetaDataRepository = $classMetaDataRepositoryFactoryAdapter->fromDataToClassMetaDataRepositoryFactory([
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper
        ])->create();

        return new ConcreteEntityAdapterAdapter($objectAdapter, $classMetaDataRepository);

    }

}
