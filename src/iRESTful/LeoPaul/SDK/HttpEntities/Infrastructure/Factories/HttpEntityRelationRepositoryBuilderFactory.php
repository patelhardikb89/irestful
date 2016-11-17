<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Builders\HttpEntityRelationRepositoryBuilder;

final class HttpEntityRelationRepositoryBuilderFactory {
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
        $this->port = $port;
        $this->headers = $headers;
	}

    public function create() {
        return new HttpEntityRelationRepositoryBuilder(
            $this->transformerObjects,
    		$this->containerClassMapper,
    		$this->interfaceClassMapper,
    		$this->delimiter,
            $this->baseUrl,
            $this->port,
            $this->headers
        );
    }

}
