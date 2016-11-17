<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityRepository;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\CurlHttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ReflectionEntityAdapterAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityRelationRepositoryBuilderFactory;

final class HttpEntityRepositoryFactory implements EntityRepositoryFactory {
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

        $entityRetrieverCriteriaAdapterFactory = new ConcreteEntityRetrieverCriteriaAdapterFactory();
        $entityRetrieverCriteriaAdapter = $entityRetrieverCriteriaAdapterFactory->create();

        $requestAdapter = new ConcreteRequestAdapter($entityRetrieverCriteriaAdapter, $this->port, $this->headers);
        $responseAdapter = new ConcreteResponseAdapter();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        $entityRepository = new HttpEntityRepository($httpApplication, $requestAdapter, $responseAdapter, $entityAdapterAdapter);

        $entityRelationRepositoryBuilderFactory = new HttpEntityRelationRepositoryBuilderFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->baseUrl,
            $this->port,
            $this->headers
        );
        $entityRelationRepository = $entityRelationRepositoryBuilderFactory->create()
                                                                            ->withEntityRepository($entityRepository)
                                                                            ->now();

        $entityRepository->addEntityRelationRepository($entityRelationRepository);
        return $entityRepository;

    }

}
