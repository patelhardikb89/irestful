<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesTests\Domain\CRUDs\Adapters\CRUDAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Objects\ConcreteTestCRUD;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteTestCRUDAdapter implements CRUDAdapter {
    private $baseNamespaces;
    public function __construct(array $baseNamespaces) {
        $this->baseNamespaces = $baseNamespaces;
    }

    public function fromDataTOCRUDs(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new TransformException('The annotated_entities keyname is mandatory in order to convert data to CRUD objects.');
        }

        if (!isset($data['installation'])) {
            throw new TransformException('The installation keyname is mandatory in order to convert data to CRUD objects.');
        }

        $output = [];
        foreach($data['annotated_entities'] as $oneAnnotatedEntity) {
            $name = $oneAnnotatedEntity->getEntity()->getInterface()->getNamespace()->getName().'Test';
            $namespace = new ConcreteNamespace(array_merge($this->baseNamespaces, [
                'Tests',
                'Tests',
                'Functional',
                'CRUDs',
                $name
            ]));

            $samples = $oneAnnotatedEntity->getSamples();
            $output[] = new ConcreteTestCRUD($namespace, $samples, $data['installation']);
        }

        return $output;

    }

}
