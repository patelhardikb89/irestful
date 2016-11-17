<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Adapters\Factories\SchemaAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteSchemaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassMetaDataRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTableFieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteForeignKeyAdapter;

final class ReflectionClassSchemaAdapterFactory implements SchemaAdapterFactory {
    private $containerClassMapper;
    private $interfaceClassMapper;
    private $engine;
    private $fieldDelimiter;
    public function __construct(array $containerClassMapper, array $interfaceClassMapper, $engine, $fieldDelimiter) {
        $this->containerClassMapper = $containerClassMapper;
        $this->interfaceClassMapper = $interfaceClassMapper;
        $this->engine = $engine;
        $this->fieldDelimiter = $fieldDelimiter;
    }

    public function create() {

        $classMetaDataRepositoryFactory = new ReflectionClassMetaDataRepositoryFactory($this->containerClassMapper, $this->interfaceClassMapper);
        $classMetaDataRepository = $classMetaDataRepositoryFactory->create();

        $foreignKeyFieldAdapter = new ConcreteTableFieldAdapter($this->fieldDelimiter);
        $foreignKeyTableAdapter = new ConcreteTableAdapter($classMetaDataRepository, $foreignKeyFieldAdapter, $this->engine, $this->fieldDelimiter);
        $foreignKeyAdapter = new ConcreteForeignKeyAdapter($foreignKeyTableAdapter);
        $fieldAdapter = new ConcreteTableFieldAdapter($this->fieldDelimiter, $foreignKeyAdapter);

        $tableAdapter = new ConcreteTableAdapter($classMetaDataRepository, $fieldAdapter, $this->engine, $this->fieldDelimiter);
        return new ConcreteSchemaAdapter($tableAdapter);

    }

}
