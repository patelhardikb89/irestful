<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Services\HttpEntityService;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Applications\CurlHttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\ConcreteHttpRequestAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionClassMetaDataRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionObjectAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;

final class HttpEntityServiceFactory implements EntityServiceFactory {
    private $baseUrl;
    private $port;
    private $headers;
    private $transformerObjects;
	private $containerClassMapper;
	private $interfaceClassMapper;
	private $delimiter;
	public function __construct(
        array $transformerObjects,
        array $containerClassMapper,
        array $interfaceClassMapper,
        $delimiter,
        $baseUrl,
        array $headers = null,
        $port = 80
    ) {
		$this->transformerObjects = $transformerObjects;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->delimiter = $delimiter;
        $this->baseUrl = $baseUrl;
        $this->port = $port;
        $this->headers = $headers;
	}

    public function create() {

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $entityRepository = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter,
            'base_url' => $this->baseUrl,
            'port' => $this->port,
            'headers' => $this->headers
        ])->create();

        $classMetaDataRepositoryFactoryAdapter = new ReflectionClassMetaDataRepositoryFactoryAdapter();
        $classMetaDataRepository = $classMetaDataRepositoryFactoryAdapter->fromDataToClassMetaDataRepositoryFactory([
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper
        ])->create();

        $objectAdapterFactoryAdapter = new ReflectionObjectAdapterFactoryAdapter();
        $objectAdapter = $objectAdapterFactoryAdapter->fromDataToObjectAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter,
            'base_url' => $this->baseUrl,
            'port' => $this->port,
            'headers' => $this->headers
        ])->create();

        $entityAdapterAdapter = new ConcreteEntityAdapterAdapter($objectAdapter, $classMetaDataRepository);
        $entityAdapterFactory = new ConcreteEntityAdapterFactory($entityRepository, $entityRelationRepository, $entityAdapterAdapter);
        $httpRequestAdapter = new ConcreteHttpRequestAdapter();
        $httpApplication = new CurlHttpApplication($httpRequestAdapter, $this->baseUrl);
        return new HttpEntityService($entityAdapterFactory, $httpApplication, $this->port, $this->headers);
    }

}
