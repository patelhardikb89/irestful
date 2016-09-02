<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Namespaces\Exceptions\NamespaceException;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;

abstract class AbstractNamespaceAdapter implements NamespaceAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromRetrievalToNamespace(Retrieval $retrieval) {
        $name = '';

        if ($retrieval->hasHttpRequest()) {
            $name = 'iRESTful\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter';
        }

        if ($retrieval->hasEntity()) {
            $name = 'iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory';
        }

        if ($retrieval->hasMultipleEntities()) {
            $name = 'iRESTful\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory';
        }

        if ($retrieval->hasEntityPartialSet()) {
            $name = 'iRESTful\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory';
        }

        if (empty($name)) {
            throw new NamespaceException('The given Retrieval object did not have a valid retrieval method.');
        }

        $exploded = explode('\\', $name);
        return new ConcreteNamespace($exploded);
    }

    public function fromConversionToNamespace(Conversion $conversion) {
        $name = 'iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory';
        $exploded = explode('\\', $name);
        return new ConcreteNamespace($exploded);
    }

    public function fromActionToNamespace(Action $action) {
        if ($action->hasHttpRequest()) {
            $name = 'iRESTful\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter';
            $exploded = explode('\\', $name);
            return new ConcreteNamespace($exploded);
        }

        if ($action->hasInsert() || $action->hasUpdate() || $action->hasDelete()) {
            $name = 'iRESTful\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory';
            $exploded = explode('\\', $name);
            return new ConcreteNamespace($exploded);
        }

        throw new NamespaceException('The given Action object did not contain a valid action.');
    }

    public function fromControllerToNamespace(Controller $controller) {
        throw new NamespaceException('The fromControllerToNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromObjectToNamespace(Object $object) {
        throw new NamespaceException('The fromObjectToNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromTypeToNamespace(Type $type) {
        throw new NamespaceException('The fromTypeToAdapterNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromTypeToAdapterNamespace(Type $type) {
        throw new NamespaceException('The fromTypeToAdapterNamespace method must be defined in every classes that extends the AbstractNamespaceAdapter class.');
    }

    public function fromPropertyTypeToNamespace(PropertyType $propertyType) {

        if ($propertyType->hasType()) {
            $type = $propertyType->getType();
            return $this->fromTypeToNamespace($type);
        }

        if ($propertyType->hasObject()) {
            $object = $propertyType->getObject();
            return $this->fromObjectToNamespace($object);
        }

        throw new NamespaceException('The given propertyType did not have a Type or an Object.  Primitives do not have namespaces.');

    }

    protected function fromDataToNamespace(array $data) {
        $merged = array_merge($this->baseNamespace, $data);
        return new ConcreteNamespace($merged);
    }

    protected function convert($name) {
        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return ucfirst($name);
    }

}
