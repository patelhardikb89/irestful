<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Builders;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntityRelationRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapterAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;

final class PDOEntityRelationRepositoryBuilder {
    private $requestRelationAdapter;
    private $pdoRepository;
    private $entityRepository;
    private $transformerObjects;
	private $containerClassMapper;
	private $interfaceClassMapper;
	private $delimiter;
    private $timezone;
    private $driver;
    private $hostname;
    private $database;
    private $username;
    private $password;
	public function __construct(
        array $transformerObjects,
        array $containerClassMapper,
        array $interfaceClassMapper,
        $delimiter,
        $timezone,
        $driver,
        $hostname,
        $database,
        $username,
        $password = null
    ) {
		$this->transformerObjects = $transformerObjects;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->delimiter = $delimiter;
        $this->timezone = $timezone;
        $this->driver = $driver;
        $this->hostname = $hostname;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->create();
	}

    public function create() {
        $this->requestRelationAdapter = null;
        return $this;
    }

    public function withRequestRelationAdapter(RequestRelationAdapter $requestRelationAdapter) {
        $this->requestRelationAdapter = $requestRelationAdapter;
        return $this;
    }

    public function withPDORepository(PDORepository $pdoRepository) {
        $this->pdoRepository = $pdoRepository;
        return $this;
    }

    public function withEntityRepository(EntityRepository $entityRepository) {
        $this->entityRepository = $entityRepository;
        return $this;
    }

    public function now() {

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        $pdoAdapterAdapter = new ConcretePDOAdapterAdapter($entityAdapterAdapter, $this->entityRepository);
        return new PDOEntityRelationRepository($this->requestRelationAdapter, $this->pdoRepository, $pdoAdapterAdapter);
    }

}
