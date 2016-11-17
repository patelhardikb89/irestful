<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestRelationAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityRelationRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteResponseAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;

final class HttpEntityRelationRepositoryFactory implements EntityRelationRepositoryFactory {
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

        $entityRelationRetrieverCriteriaAdapterFactory = new ConcreteEntityRelationRetrieverCriteriaAdapterFactory();
        $entityRelationRetrieverCriteriaAdapter = $entityRelationRetrieverCriteriaAdapterFactory->create();
        $requestRelationAdapter = new ConcreteRequestRelationAdapter($entityRelationRetrieverCriteriaAdapter, $this->port, $this->headers);

        $responseAdapter = new ConcreteResponseAdapter();

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

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();


        $repository = new HttpEntityRelationRepository($httpApplication, $requestRelationAdapter, $responseAdapter);
        $entityAdapterFactory = new ConcreteEntityAdapterFactory($entityRepository, $repository, $entityAdapterAdapter);
        $repository->addEntityAdapterFactory($entityAdapterFactory);
        return $repository;
    }

}
