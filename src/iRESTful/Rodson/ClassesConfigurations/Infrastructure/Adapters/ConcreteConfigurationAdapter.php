<?php
namespace iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesConfigurations\Domain\Adapters\ConfigurationAdapter;
use iRESTful\Rodson\ClassesConfigurations\Domain\Objects\Adapters\ObjectConfigurationAdapter;
use iRESTful\Rodson\ClassesConfigurations\Domain\Exceptions\ConfigurationException;
use iRESTful\Rodson\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Objects\ConcreteConfiguration;
use iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Nodes\Adapters\ControllerNodeAdapter;

final class ConcreteConfigurationAdapter implements ConfigurationAdapter {
    private $namespaceFactory;
    private $objectConfigurationAdapter;
    private $controllerAdapter;
    private $controllerNodeAdapter;
    public function __construct(
        NamespaceFactory $namespaceFactory,
        ObjectConfigurationAdapter $objectConfigurationAdapter,
        ControllerNodeAdapter $controllerNodeAdapter
    ) {
        $this->namespaceFactory = $namespaceFactory;
        $this->objectConfigurationAdapter = $objectConfigurationAdapter;
        $this->controllerNodeAdapter = $controllerNodeAdapter;
    }

    public function fromDataToConfiguration(array $data) {

        $getDatabasesFromAnnotatedEntities = function(array $annotatedEntities) {

            $databases = [];
            foreach($annotatedEntities as $oneAnnotatedEntity) {
                $database = $oneAnnotatedEntity->getEntity()->getEntity()->getDatabase();
                $name = $database->getName();
                if (!isset($databases[$name])) {
                    $databases[$name] = $database;
                }
            }

            return array_values($databases);

        };

        if (!isset($data['annotated_entities'])) {
            throw new ConfigurationException('The annotated_entities keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['annotated_objects'])) {
            throw new ConfigurationException('The annotated_objects keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['values'])) {
            throw new ConfigurationException('The values keyname is mandatory in order to convert data to a Configuration object.');
        }

        $databases = $getDatabasesFromAnnotatedEntities($data['annotated_entities']);
        $namespace = $this->namespaceFactory->create();
        $objectConfiguration = $this->objectConfigurationAdapter->fromDataToObjectConfiguration([
            'annotated_entities' => $data['annotated_entities'],
            'annotated_objects' => $data['annotated_objects'],
            'values' => $data['values']
        ]);

        $controllerNode = null;
        if (!isset($data['controllers'])) {
            $controllerNode = $this->controllerNodeAdapter->fromDataToControllerNode($data['controllers']);
        }

        return new ConcreteConfiguration($namespace, $objectConfiguration, $databases, $controllerNode);

    }

}
