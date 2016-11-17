<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteResponseAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestSetAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;

final class HttpEntitySetRepositoryFactory implements EntitySetRepositoryFactory {
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

        $uuidAdapter = new ConcreteUuidAdapter();
        $keynameAdapter = new ConcreteKeynameAdapter();
        $orderingAdapter = new ConcreteOrderingAdapter();
        $entitySetRetrieverCriteriaAdapter = new ConcreteEntitySetRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter, $orderingAdapter);

        $requestSetAdapter = new ConcreteRequestSetAdapter($entitySetRetrieverCriteriaAdapter, $uuidAdapter, $orderingAdapter, $this->port, $this->headers);
        $responseAdapter = new ConcreteResponseAdapter();

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $entityRepositoryFactory = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter,
            'base_url' => $this->baseUrl,
            'port' => $this->port,
            'headers' => $this->headers
        ]);
        $entityRepository = $entityRepositoryFactory->create();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
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

        $entityAdapterFactory = new ConcreteEntityAdapterFactory($entityRepository, $entityRelationRepository, $entityAdapterAdapter);
        return new HttpEntitySetRepository($httpApplication, $requestSetAdapter, $responseAdapter, $entityAdapterFactory);

    }

}
