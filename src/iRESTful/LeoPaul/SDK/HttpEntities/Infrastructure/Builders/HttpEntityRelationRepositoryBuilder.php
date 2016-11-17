<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Builders;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestRelationAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityRelationRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteResponseAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;

final class HttpEntityRelationRepositoryBuilder {
    private $entityRepository;
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
        $port = 80,
        array $headers = null
    ) {
		$this->transformerObjects = $transformerObjects;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->delimiter = $delimiter;
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;
        $this->port = $port;
        $this->create();
	}

    public function create() {
        $this->entityRepository = null;
        return $this;
    }

    public function withEntityRepository(EntityRepository $entityRepository) {
        $this->entityRepository = $entityRepository;
        return $this;
    }

    public function now() {
        $httpApplicationAdapter = new CurlHttpApplicationFactoryAdapter();
        $httpApplication = $httpApplicationAdapter->fromDataToHttpApplicationFactory([
            'base_url' => $this->baseUrl
        ])->create();

        $entityRelationRetrieverCriteriaAdapterFactory = new ConcreteEntityRelationRetrieverCriteriaAdapterFactory();
        $entityRelationRetrieverCriteriaAdapter = $entityRelationRetrieverCriteriaAdapterFactory->create();
        $requestRelationAdapter = new ConcreteRequestRelationAdapter($entityRelationRetrieverCriteriaAdapter, $this->port, $this->headers);

        $responseAdapter = new ConcreteResponseAdapter();
        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        $repository = new HttpEntityRelationRepository($httpApplication, $requestRelationAdapter, $responseAdapter);
        $entityAdapterFactory = new ConcreteEntityAdapterFactory($this->entityRepository, $repository, $entityAdapterAdapter);
        $repository->addEntityAdapterFactory($entityAdapterFactory);
        return $repository;
    }

}
