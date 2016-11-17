<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteObjectMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteClassMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArrayMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteArgumentMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteConstructorMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassMetaDataRepositoryFactory;

final class ReflectionObjectAdapterFactory implements ObjectAdapterFactory {
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

		$objectMetaDataAdapter = new ConcreteObjectMetaDataAdapter();
		$transformerWrapperAdapter = new ConcreteTransformerWrapperAdapter($this->transformerObjects);

		$arrayMetaDataWrapperAdapter = new ConcreteArrayMetaDataWrapperAdapter($transformerWrapperAdapter);
		$argumentMetaDataWrapperAdapter = new ConcreteArgumentMetaDataWrapperAdapter($arrayMetaDataWrapperAdapter);
		$constructorMetaDataWrapperAdapter = new ConcreteConstructorMetaDataWrapperAdapter($argumentMetaDataWrapperAdapter, $transformerWrapperAdapter, $this->delimiter);
		$classMetaDataWrapperAdapter = new ConcreteClassMetaDataWrapperAdapter($constructorMetaDataWrapperAdapter);

        $classMetaDataRepositoryFactory = new ReflectionClassMetaDataRepositoryFactory($this->containerClassMapper, $this->interfaceClassMapper);
		$classMetaDataRepository = $classMetaDataRepositoryFactory->create();
		return new ConcreteObjectAdapter($transformerWrapperAdapter, $objectMetaDataAdapter, $classMetaDataWrapperAdapter, $classMetaDataRepository, $this->containerClassMapper, $this->interfaceClassMapper, $this->delimiter);
	}

}
