<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Services\HttpEntitySetService;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionClassMetaDataRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionObjectAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;

final class HttpEntitySetServiceFactory implements EntitySetServiceFactory {
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

        $httpApplicationAdapter = new CurlHttpApplicationFactoryAdapter();
        $httpApplication = $httpApplicationAdapter->fromDataToHttpApplicationFactory([
            'base_url' => $this->baseUrl
        ])->create();

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

        return new HttpEntitySetService($entityAdapterFactory, $httpApplication, $this->port, $this->headers);

    }

}
