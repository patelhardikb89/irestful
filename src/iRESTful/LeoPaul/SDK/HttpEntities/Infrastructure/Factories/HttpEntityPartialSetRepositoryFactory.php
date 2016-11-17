<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityPartialSetRepository;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityPartialSetRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteResponseAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;

final class HttpEntityPartialSetRepositoryFactory implements EntityPartialSetRepositoryFactory {
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

        $orderingAdapter = new ConcreteOrderingAdapter();

        $entityPartialSetRetrieverCriteriaAdapterFactory = new ConcreteEntityPartialSetRetrieverCriteriaAdapterFactory();
        $entityPartialSetRetrieverCriteriaAdapter = $entityPartialSetRetrieverCriteriaAdapterFactory->create();
        $requestPartialSetAdapter = new ConcreteRequestPartialSetAdapter($entityPartialSetRetrieverCriteriaAdapter, $orderingAdapter, $this->port, $this->headers);

        $responseAdapter = new ConcreteResponseAdapter();
        $entityPartialSetAdapterFactoryAdapter = new HttpEntityPartialSetAdapterFactoryAdapter();
        $entityPartialSetAdapter = $entityPartialSetAdapterFactoryAdapter->fromDataToEntityPartialSetAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter,
            'base_url' => $this->baseUrl,
            'headers' => $this->headers,
            'port' => $this->port
        ])->create();
        
        return new HttpEntityPartialSetRepository(
            $httpApplication,
            $requestPartialSetAdapter,
            $responseAdapter,
            $entityPartialSetAdapter
        );

    }

}
